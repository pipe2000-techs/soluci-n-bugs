@extends('layouts.app')
@section('title', 'Crear Proyecto')

@section('content')
<div class="max-w-xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Crear Proyecto</h1>

    <form action="{{ route('projects.store') }}" method="POST" class="bg-white rounded-lg border border-gray-200 p-6 space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripcion</label>
            <textarea name="description" id="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
        </div>

        <div>
            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Fecha limite</label>
            <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
            <select name="status" id="status" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach(App\Models\Project::$statuses as $value)
                    <option value="{{ $value }}" {{ old('status', 'en_progreso') === $value ? 'selected' : '' }}>
                        {{ match($value) { 'backlog' => 'Backlog', 'en_progreso' => 'En Progreso', 'testing' => 'Testing', 'terminada' => 'Terminada' } }}
                    </option>
                @endforeach
            </select>
            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">Crear</button>
            <a href="{{ route('projects.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">Cancelar</a>
        </div>
    </form>
</div>
@endsection
