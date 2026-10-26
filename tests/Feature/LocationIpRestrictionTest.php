<?php

namespace Tests\Feature;

use App\Filament\Pages\IpConfiguration;
use App\Models\Employee;
use App\Models\IpRequest;
use App\Models\Location;
use App\Models\User;
use App\Services\IpMatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LocationIpRestrictionTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected Employee $employee;
    protected Location $location;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::firstOrCreate(
            ['email' => 'admin_ip@example.com'],
            ['name' => 'Admin IP', 'password' => bcrypt('password')]
        );

        $this->employee = Employee::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'johndoe',
            'password' => bcrypt('password'),
            'birthdate' => '1995-05-15',
            'address' => 'Sample Address',
            'mobile_number' => '09123456789',
            'roles' => ['timesheet_portal'],
        ]);

        $this->location = Location::create([
            'name' => 'Crystal Cave',
            'ip_address' => '192.168.88.09',
        ]);
    }

    public function test_ip_matcher_normalizes_leading_zeros(): void
    {
        // 192.168.88.09 should match 192.168.88.9
        $this->assertTrue(IpMatcher::matches('192.168.88.9', '192.168.88.09'));
        $this->assertTrue(IpMatcher::matches('192.168.88.09', '192.168.88.9'));
        $this->assertFalse(IpMatcher::matches('192.168.88.10', '192.168.88.09'));
    }

    public function test_ip_matcher_handles_multiple_ips_and_wildcards(): void
    {
        $this->assertTrue(IpMatcher::matches('10.0.0.5', '192.168.1.1, 10.0.0.5, 172.16.0.1'));
        $this->assertTrue(IpMatcher::matches('192.168.1.55', '192.168.1.*'));
        $this->assertFalse(IpMatcher::matches('192.168.2.55', '192.168.1.*'));
    }

    public function test_admin_can_add_edit_and_delete_locations_on_ip_configuration_page(): void
    {
        Livewire::actingAs($this->adminUser)
            ->test(IpConfiguration::class)
            ->call('openCreateModal')
            ->set('name', 'Main Office')
            ->set('ip_address', '10.0.0.1')
            ->call('saveLocation');

        $this->assertDatabaseHas('locations', [
            'name' => 'Main Office',
            'ip_address' => '10.0.0.1',
        ]);

        $mainOffice = Location::where('name', 'Main Office')->first();

        Livewire::actingAs($this->adminUser)
            ->test(IpConfiguration::class)
            ->call('openEditModal', $mainOffice->id)
            ->set('ip_address', '10.0.0.2')
            ->call('saveLocation');

        $this->assertDatabaseHas('locations', [
            'id' => $mainOffice->id,
            'ip_address' => '10.0.0.2',
        ]);

        Livewire::actingAs($this->adminUser)
            ->test(IpConfiguration::class)
            ->call('deleteLocation', $mainOffice->id);

        $this->assertDatabaseMissing('locations', [
            'id' => $mainOffice->id,
        ]);
    }

    public function test_employee_can_have_multiple_assigned_locations(): void
    {
        $branch = Location::create([
            'name' => 'Branch Office',
            'ip_address' => '172.16.10.20',
        ]);

        $this->employee->locations()->attach([$this->location->id, $branch->id]);

        $this->assertCount(2, $this->employee->fresh()->locations);
        $this->assertTrue($this->employee->fresh()->isIpAuthorized('192.168.88.9'));
        $this->assertTrue($this->employee->fresh()->isIpAuthorized('172.16.10.20'));
        $this->assertFalse($this->employee->fresh()->isIpAuthorized('1.2.3.4'));
    }

    public function test_employee_with_unauthorized_ip_is_redirected_to_ip_request_page(): void
    {
        $this->employee->locations()->attach($this->location->id);

        // Access portal from unauthorized IP (e.g. 203.0.113.50)
        $response = $this->actingAs($this->employee, 'employee')
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.50'])
            ->get('/portal');

        $response->assertRedirect(route('portal.ipRequest'));
    }

    public function test_employee_with_authorized_ip_can_access_portal(): void
    {
        $this->employee->locations()->attach($this->location->id);

        // Access portal from authorized IP (192.168.88.9 matching 192.168.88.09)
        $response = $this->actingAs($this->employee, 'employee')
            ->withServerVariables(['REMOTE_ADDR' => '192.168.88.9'])
            ->get('/portal');

        $response->assertSuccessful();
        $response->assertSee('John Doe');
    }

    public function test_employee_can_submit_ip_registration_request(): void
    {
        $this->employee->locations()->attach($this->location->id);

        $response = $this->actingAs($this->employee, 'employee')
            ->withServerVariables(['REMOTE_ADDR' => '203.0.113.77'])
            ->post('/portal/ip-request', [
                'location_id' => $this->location->id,
                'description' => 'New home fiber router IP installed for remote duty.',
            ]);

        $response->assertRedirect(route('portal.ipRequest'));

        $this->assertDatabaseHas('ip_requests', [
            'employee_id' => $this->employee->id,
            'location_id' => $this->location->id,
            'ip_address' => '203.0.113.77',
            'description' => 'New home fiber router IP installed for remote duty.',
            'status' => 'pending',
        ]);
    }

    public function test_admin_approving_ip_request_automatically_registers_ip_on_location(): void
    {
        $ipRequest = IpRequest::create([
            'employee_id' => $this->employee->id,
            'location_id' => $this->location->id,
            'location_name' => $this->location->name,
            'ip_address' => '203.0.113.88',
            'description' => 'Updated router IP at Crystal Cave',
            'status' => 'pending',
        ]);

        $this->assertEquals('1', IpConfiguration::getNavigationBadge());

        Livewire::actingAs($this->adminUser)
            ->test(IpConfiguration::class)
            ->call('approveRequest', $ipRequest->id);

        $ipRequest->refresh();
        $this->assertEquals('approved', $ipRequest->status);

        // Verify the location's IP address was automatically registered
        $this->location->refresh();
        $this->assertEquals('203.0.113.88', $this->location->ip_address);

        // Verify badge is cleared
        $this->assertNull(IpConfiguration::getNavigationBadge());

        // Verify employee can now access portal with the newly approved IP
        $this->employee->refresh();
        $this->assertTrue($this->employee->isIpAuthorized('203.0.113.88'));
    }
}
