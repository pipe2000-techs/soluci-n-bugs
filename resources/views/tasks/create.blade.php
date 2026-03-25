@extends('layouts.app')
@section('title', 'Nueva Tarea')

@section('content')
<div class="max-w-xl mx-auto">
    <a href="{{ route('projects.show', $project) }}" class="text-sm text-blue-600 hover:underline mb-4 inline-block">&larr; {{ $project->name }}</a>
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Nueva Tarea</h1>

    <form action="{{ route('projects.tasks.store', $project) }}" method="POST" class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Titulo *</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripcion</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
                <select name="priority" id="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="baja" {{ old('priority') == 'baja' ? 'selected' : '' }}>Baja</option>
                    <option value="media" {{ old('priority', 'media') == 'media' ? 'selected' : '' }}>Media</option>
                    <option value="alta" {{ old('priority') == 'alta' ? 'selected' : '' }}>Alta</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="backlog" selected>Backlog</option>
                    <option value="en_progreso">En Progreso</option>
                    <option value="testing">Testing</option>
                    <option value="terminada">Terminada</option>
                </select>
            </div>
        </div>

        <div>
            <label for="estimated_hours" class="block text-sm font-medium text-gray-700 mb-1">Horas estimadas *</label>
            <input type="number" name="estimated_hours" id="estimated_hours" value="{{ old('estimated_hours', 0) }}" required step="0.5" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Crear Tarea</button>
            <a href="{{ route('projects.show', $project) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">Cancelar</a>
        </div>
    </form>
</div>
@endsection
