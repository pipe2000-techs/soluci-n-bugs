@extends('layouts.app')
@section('title', $project->name)

@section('content')
<div class="flex items-start justify-between mb-6">
    <div>
        <a href="{{ route('projects.index') }}" class="text-sm text-blue-600 hover:underline mb-2 inline-block">&larr; Proyectos</a>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl font-bold text-gray-800">{{ $project->name }}</h1>
            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $project->status_label }}</span>
        </div>
        @if($project->description)
            <p class="text-gray-500 mt-1">{{ $project->description }}</p>
        @endif
    </div>
    <div class="flex gap-2">
        <a href="{{ route('projects.edit', $project) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm">Editar</a>
        <a href="{{ route('projects.tasks.create', $project) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm">+ Tarea</a>
    </div>
</div>

{{-- Resumen del proyecto --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Tareas</p>
        <p class="text-2xl font-bold text-gray-800">{{ $project->tasks->count() }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Completadas</p>
        <p class="text-2xl font-bold text-green-600">{{ $project->completed_tasks_count }}</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Horas Estimadas</p>
        <p class="text-2xl font-bold text-blue-600">{{ $project->total_estimated_hours }}h</p>
    </div>
    <div class="bg-white rounded-lg border border-gray-200 p-4">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Avance</p>
        <p class="text-2xl font-bold text-purple-600">{{ $project->progress }}%</p>
    </div>
</div>

@if($project->deadline)
    <p class="text-sm text-gray-500 mb-4">Fecha limite: <strong>{{ $project->deadline->format('d/m/Y') }}</strong></p>
@endif

{{-- Lista de tareas agrupadas por estado --}}
@php
    $statuses = ['backlog' => 'Backlog', 'en_progreso' => 'En Progreso', 'testing' => 'Testing', 'terminada' => 'Terminada'];
    $statusColors = ['backlog' => 'gray', 'en_progreso' => 'blue', 'testing' => 'yellow', 'terminada' => 'green'];
@endphp

<div class="grid md:grid-cols-4 gap-4">
    @foreach($statuses as $statusKey => $statusLabel)
        @php $filteredTasks = $project->tasks->where('status', $statusKey); @endphp
        <div>
            <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mb-3 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-{{ $statusColors[$statusKey] }}-500"></span>
                {{ $statusLabel }}
                <span class="text-gray-400">({{ $filteredTasks->count() }})</span>
            </h3>
            <div class="space-y-2">
                @forelse($filteredTasks as $task)
                    <div class="bg-white rounded-lg border border-gray-200 p-3 hover:shadow-sm transition">
                        <a href="{{ route('projects.tasks.show', [$project, $task]) }}" class="block">
                            <p class="font-medium text-gray-800 text-sm">{{ $task->title ?: '(sin titulo)' }}</p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs px-2 py-0.5 rounded-full bg-{{ $task->priority_color }}-100 text-{{ $task->priority_color }}-700">{{ $task->priority }}</span>
                                <span class="text-xs text-gray-400">{{ $task->total_estimated_hours }}h</span>
                                @if($task->subtasks->count())
                                    <span class="text-xs text-gray-400">{{ $task->subtasks->count() }} sub</span>
                                @endif
                            </div>
                        </a>
                        <form action="{{ route('projects.tasks.update-status', [$project, $task]) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="w-full text-xs border border-gray-200 rounded px-2 py-1 text-gray-600">
                                @foreach($statuses as $sKey => $sLabel)
                                    <option value="{{ $sKey }}" {{ $task->status === $sKey ? 'selected' : '' }}>{{ $sLabel }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-gray-400 italic">Sin tareas</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

{{-- Eliminar proyecto --}}
<div class="mt-12 pt-6 border-t border-gray-200">
    <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Estas seguro de eliminar este proyecto?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm text-red-500 hover:text-red-700">Eliminar proyecto</button>
    </form>
</div>
@endsection
