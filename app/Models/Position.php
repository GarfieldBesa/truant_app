<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'base_rate',
        'overtime_rate',
        'sss',
        'philhealth',
        'pag_ibig',
    ];

    protected function casts(): array
    {
        return [
            'base_rate' => 'decimal:2',
            'overtime_rate' => 'decimal:2',
            'sss' => 'decimal:2',
            'philhealth' => 'decimal:2',
            'pag_ibig' => 'decimal:2',
        ];
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(PositionAuditLog::class);
    }

    protected static function booted()
    {
        static::updated(function ($position) {
            $changes = [];
            foreach ($position->getChanges() as $key => $newValue) {
                if ($key === 'updated_at') continue;
                $oldValue = $position->getOriginal($key);
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }

            if (!empty($changes)) {
                $position->auditLogs()->create([
                    'user_id' => auth()->id(),
                    'action' => 'updated',
                    'changes' => $changes,
                ]);
            }
        });

        static::created(function ($position) {
            $changes = [];
            foreach ($position->getAttributes() as $key => $value) {
                if (in_array($key, ['id', 'created_at', 'updated_at'])) continue;
                $changes[$key] = [
                    'old' => null,
                    'new' => $value,
                ];
            }
            $position->auditLogs()->create([
                'user_id' => auth()->id(),
                'action' => 'created',
                'changes' => $changes,
            ]);
        });
    }
}
