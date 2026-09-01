<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionAuditLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'position_id',
        'user_id',
        'action',
        'changes',
    ];

    protected function casts(): array
    {
        return [
            'changes' => 'array',
        ];
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
