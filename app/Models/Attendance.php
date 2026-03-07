<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    public const STATUS_ATTENDING = 'ATTENDING';
    public const STATUS_NOT_ATTENDING = 'NOT_ATTENDING';
    public const STATUS_PENDING = 'PENDING';

    protected $fillable = [
        'event_id',
        'member_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}
