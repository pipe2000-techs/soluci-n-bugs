@extends('layouts.app')
@section('title', $task->title ?: 'Tarea')

@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('projects.show', $project) }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; {{ $project->name }}</a>

    <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $task->title ?: '(sin titulo)' }}</h1>
                @if($task->description)
                    <p class="text-gray-500 mt-2">{{ $task->description }}</p>
                @endif
            </div>
            <div class="flex gap-2">
                <a href="{{ route('projects.tasks.edit', [$project, $task]) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm">Editar</a>
                <form action="{{ route('projects.tasks.destroy', [$project, $task]) }}" method="POST" onsubmit="return confirm('Eliminar esta tarea?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-2 rounded-lg text-sm">Eliminar</button>
                </form>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-4">
            <span class="text-xs px-2 py-1 rounded-full bg-{{ $task->priority_color }}-100 text-{{ $task->priority_color }}-700 font-medium">{{ $task->priority }}</span>
            <span class="text-sm text-gray-600">Estado: <strong>{{ $task->status_label }}</strong></span>
            <span class="text-sm text-gray-600">{{ $task->total_estimated_hours }}h totales</span>
        </div>
    </div>

    {{-- Subtareas --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Subtareas ({{ $task->subtasks->count() }})</h2>

        @if($task->subtasks->count())
            <div class="space-y-3 mb-6">
                @foreach($task->subtasks as $subtask)
                    <div class="flex items-center justify-between bg-gray-50 rounded-lg p-3">
                        <div class="flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full {{ $subtask->status === 'terminada' ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                            <span class="text-sm text-gray-800">{{ $subtask->title }}</span>
                            <span class="text-xs text-gray-400">{{ $subtask->estimated_hours }}h</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <form action="{{ route('projects.tasks.subtasks.update', [$project, $task, $subtask]) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="title" value="{{ $subtask->title }}">
                                <input type="hidden" name="estimated_hours" value="{{ $subtask->estimated_hours }}">
                                <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded px-2 py-1">
                                    @foreach(['backlog', 'en_progreso', 'testing', 'terminada'] as $s)
                                        <option value="{{ $s }}" {{ $subtask->status === $s ? 'selected' : '' }}>
                                            {{ match($s) { 'backlog' => 'Backlog', 'en_progreso' => 'En Progreso', 'testing' => 'Testing', 'terminada' => 'Terminada' } }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <form action="{{ route('projects.tasks.subtasks.destroy', [$project, $task, $subtask]) }}" method="POST" onsubmit="return confirm('Eliminar?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs">x</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Agregar subtarea --}}
        <form action="{{ route('projects.tasks.subtasks.store', [$project, $task]) }}" method="POST" class="flex items-end gap-3">
            @csrf
            <div class="flex-1">
                <label class="block text-xs text-gray-500 mb-1">Nueva subtarea</label>
                <input type="text" name="title" required placeholder="Nombre de la subtarea" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="w-24">
                <label class="block text-xs text-gray-500 mb-1">Horas</label>
                <input type="number" name="estimated_hours" value="0" step="0.5" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Agregar</button>
        </form>
    </div>
</div>
@endsection
