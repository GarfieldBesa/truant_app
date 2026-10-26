<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ip_address',
    ];

    /**
     * Relationship: Employees assigned to this location.
     */
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_location');
    }

    /**
     * Relationship: IP Requests for this location.
     */
    public function ipRequests()
    {
        return $this->hasMany(IpRequest::class);
    }

    /**
     * Check if a given client IP matches this location's registered IP(s).
     */
    public function matchesIp(?string $clientIp): bool
    {
        if (empty($clientIp) || empty($this->ip_address)) {
            return false;
        }

        return \App\Services\IpMatcher::matches($clientIp, $this->ip_address);
    }
}
