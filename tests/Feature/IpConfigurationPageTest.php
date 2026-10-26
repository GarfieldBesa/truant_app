<?php

namespace Tests\Feature;

use App\Filament\Pages\IpConfiguration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class IpConfigurationPageTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['email' => 'admin_ip_test@example.com'],
            ['name' => 'Admin IP Tester', 'password' => bcrypt('password')]
        );
    }

    public function test_admin_can_access_ip_configuration_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/ip-configuration');

        $response->assertSuccessful();
        $response->assertSee('IP Configuration');
        $response->assertSee('Locations');
    }

    public function test_ip_configuration_page_can_be_tested_via_livewire(): void
    {
        Livewire::actingAs($this->admin)
            ->test(IpConfiguration::class)
            ->assertSuccessful()
            ->assertSee('IP Configuration');
    }
}
