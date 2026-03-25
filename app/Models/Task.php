<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $fillable = ['project_id', 'title', 'description', 'priority', 'status', 'estimated_hours'];

    protected $casts = [
        'estimated_hours' => 'float',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Subtask::class);
    }

    public static array $priorities = ['alta', 'media', 'baja'];
    public static array $statuses = ['backlog', 'en_progreso', 'testing', 'terminada'];

    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            'alta' => 'red',
            'media' => 'yellow',
            'baja' => 'green',
            default => 'gray',
        };
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

    public function getTotalEstimatedHoursAttribute(): float
    {
        return (float) ($this->estimated_hours + $this->subtasks->sum('estimated_hours'));
    }
}
