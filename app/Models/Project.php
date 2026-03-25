<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'deadline'];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

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
}
