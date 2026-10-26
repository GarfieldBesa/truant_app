<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'location_id',
        'location_name',
        'ip_address',
        'description',
        'status',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Approve this request and register the IP address on the location.
     */
    public function approve(): void
    {
        $this->status = 'approved';
        $this->reviewed_at = Carbon::now();
        $this->save();

        // 1. Find or create the location
        $location = null;
        if ($this->location_id) {
            $location = Location::find($this->location_id);
        }

        if (! $location && ! empty($this->location_name)) {
            $location = Location::where('name', $this->location_name)->first();
        }

        if ($location) {
            // Register / update the IP address on the location
            // If the location already has an IP address, we update it or append if multiple
            $existingIps = array_filter(array_map('trim', explode(',', $location->ip_address ?? '')));
            if (! in_array(trim($this->ip_address), $existingIps)) {
                $location->ip_address = trim($this->ip_address);
                $location->save();
            }
        } elseif (! empty($this->location_name)) {
            $location = Location::create([
                'name' => $this->location_name,
                'ip_address' => trim($this->ip_address),
            ]);
            $this->location_id = $location->id;
            $this->save();
        }

        // 2. Ensure employee is assigned to this location
        if ($location && $this->employee) {
            if (! $this->employee->locations()->where('locations.id', $location->id)->exists()) {
                $this->employee->locations()->attach($location->id);
            }
        }
    }

    /**
     * Reject this request.
     */
    public function reject(): void
    {
        $this->status = 'rejected';
        $this->reviewed_at = Carbon::now();
        $this->save();
    }
}
