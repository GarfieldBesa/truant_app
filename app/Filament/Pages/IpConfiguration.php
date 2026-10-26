<?php

namespace App\Filament\Pages;

use App\Models\IpRequest;
use App\Models\Location;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class IpConfiguration extends Page
{
    protected static \UnitEnum|string|null $navigationGroup = null;

    protected static ?string $navigationLabel = 'IP Configuration';

    protected static ?string $title = 'IP Configuration';

    protected static ?int $navigationSort = 5;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected string $view = 'filament.pages.ip-configuration';

    // Livewire state properties
    public string $name = '';
    public string $ip_address = '';
    public ?int $editingId = null;
    public string $search = '';
    public bool $showLocationModal = false;
    public string $modalMode = 'create'; // 'create' or 'edit'

    /**
     * Notification badge on the sidebar displaying pending user IP requests.
     */
    public static function getNavigationBadge(): ?string
    {
        try {
            if (! \Illuminate\Support\Facades\Schema::hasTable('ip_requests')) {
                return null;
            }

            $count = IpRequest::where('status', 'pending')->count();

            return $count > 0 ? (string) $count : null;
        } catch (\Throwable) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    /**
     * Open modal to create a new location.
     */
    public function openCreateModal(): void
    {
        $this->resetValidation();
        $this->name = '';
        $this->ip_address = '';
        $this->editingId = null;
        $this->modalMode = 'create';
        $this->showLocationModal = true;
    }

    /**
     * Open modal to edit an existing location.
     */
    public function openEditModal(int $id): void
    {
        $this->resetValidation();
        $location = Location::findOrFail($id);

        $this->editingId = $location->id;
        $this->name = $location->name;
        $this->ip_address = $location->ip_address;
        $this->modalMode = 'edit';
        $this->showLocationModal = true;
    }

    /**
     * Close the location modal.
     */
    public function closeModal(): void
    {
        $this->showLocationModal = false;
        $this->editingId = null;
        $this->name = '';
        $this->ip_address = '';
        $this->resetValidation();
    }

    /**
     * Save (Create or Update) location.
     */
    public function saveLocation(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|string|max:255',
        ], [
            'name.required' => 'Location name is required.',
            'ip_address.required' => 'IP address is required.',
        ]);

        if ($this->modalMode === 'edit' && $this->editingId) {
            $location = Location::findOrFail($this->editingId);
            $location->update([
                'name' => trim($this->name),
                'ip_address' => trim($this->ip_address),
            ]);

            Notification::make()
                ->title('Location Updated')
                ->body("Location '{$location->name}' updated successfully.")
                ->success()
                ->send();
        } else {
            $location = Location::create([
                'name' => trim($this->name),
                'ip_address' => trim($this->ip_address),
            ]);

            Notification::make()
                ->title('Location Created')
                ->body("Location '{$location->name}' added successfully.")
                ->success()
                ->send();
        }

        $this->closeModal();
    }

    /**
     * Delete a location.
     */
    public function deleteLocation(int $id): void
    {
        $location = Location::findOrFail($id);
        $name = $location->name;
        $location->delete();

        Notification::make()
            ->title('Location Deleted')
            ->body("Location '{$name}' has been deleted.")
            ->success()
            ->send();
    }

    /**
     * Approve a pending IP request from a user.
     * Automatically registers the IP address on the requested location.
     */
    public function approveRequest(int $id): void
    {
        $request = IpRequest::with(['employee', 'location'])->findOrFail($id);
        $request->approve();

        $employeeName = $request->employee ? "{$request->employee->first_name} {$request->employee->last_name}" : 'Employee';
        $locationName = $request->location?->name ?? $request->location_name ?? 'Location';

        Notification::make()
            ->title('IP Request Approved')
            ->body("Approved IP ({$request->ip_address}) for {$employeeName}. Automatically registered on location '{$locationName}'.")
            ->success()
            ->send();
    }

    /**
     * Reject a pending IP request from a user.
     */
    public function rejectRequest(int $id): void
    {
        $request = IpRequest::findOrFail($id);
        $request->reject();

        Notification::make()
            ->title('IP Request Rejected')
            ->body("The IP registration request for {$request->ip_address} has been rejected.")
            ->warning()
            ->send();
    }

    /**
     * Delete an IP request record.
     */
    public function deleteRequest(int $id): void
    {
        $request = IpRequest::findOrFail($id);
        $request->delete();

        Notification::make()
            ->title('Request Removed')
            ->body('The request record has been removed.')
            ->success()
            ->send();
    }

    /**
     * Provide data to the Blade view.
     */
    public function getViewData(): array
    {
        $query = Location::withCount('employees')->orderBy('name');

        if (! empty($this->search)) {
            $s = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', $s)
                  ->orWhere('ip_address', 'like', $s);
            });
        }

        $locations = $query->get();

        $pendingRequests = IpRequest::with(['employee', 'location'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $recentRequests = IpRequest::with(['employee', 'location'])
            ->where('status', '!=', 'pending')
            ->orderBy('reviewed_at', 'desc')
            ->take(10)
            ->get();

        return [
            'locations' => $locations,
            'pendingRequests' => $pendingRequests,
            'recentRequests' => $recentRequests,
            'totalLocations' => Location::count(),
            'pendingCount' => $pendingRequests->count(),
        ];
    }
}
