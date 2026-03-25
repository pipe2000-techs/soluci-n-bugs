<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subtask extends Model
{
    protected $fillable = ['task_id', 'title', 'status', 'estimated_hours'];

    protected $casts = [
        'estimated_hours' => 'float',
    ];

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'backlog' => 'Backlog',
            'en_progreso' => 'En Progreso',
            'testing' => 'Testing',
            'terminada' => 'Terminada',
            default => $this->status,
        };
    }
}
