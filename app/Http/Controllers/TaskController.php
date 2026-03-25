<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:alta,media,baja',
            'status' => 'required|in:backlog,en_progreso,testing,terminada',
            'estimated_hours' => 'required|numeric|min:0',
        ]);

        $project->tasks()->create($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Tarea creada exitosamente.');
    }

    public function show(Project $project, Task $task)
    {
        $task->load('subtasks');
        return view('tasks.show', compact('project', 'task'));
    }

    public function edit(Project $project, Task $task)
    {
        return view('tasks.edit', compact('project', 'task'));
    }

    public function update(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:alta,media,baja',
            'status' => 'required|in:backlog,en_progreso,testing,terminada',
            'estimated_hours' => 'required|numeric|min:0',
        ]);

        $task->update($validated);

        return redirect()->route('projects.tasks.show', [$project, $task])->with('success', 'Tarea actualizada.');
    }

    public function updateStatus(Request $request, Project $project, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:backlog,en_progreso,testing,terminada',
        ]);

        $task->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Estado actualizado.');
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();
        return redirect()->route('projects.show', $project)->with('success', 'Tarea eliminada.');
    }
}
