<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'deadline', 'status'];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public static array $statuses = ['backlog', 'en_progreso', 'testing', 'terminada'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getTotalEstimatedHoursAttribute(): float
    {
        return $this->tasks->sum(fn ($task) => $task->total_estimated_hours);
    }

    public function getCompletedTasksCountAttribute(): int
    {
        return $this->tasks->where('status', 'terminada')->count();
    }

    public function getProgressAttribute(): int
    {
        $total = $this->tasks->count();
        if ($total === 0) return 0;
        return (int) round(($this->completed_tasks_count / $total) * 100);
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
