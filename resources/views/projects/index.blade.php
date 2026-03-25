@extends('layouts.app')
@section('title', 'Proyectos')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Proyectos</h1>
    <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
        + Nuevo Proyecto
    </a>
</div>

@if($projects->isEmpty())
    <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
        <p class="text-gray-500 mb-4">No hay proyectos todavia.</p>
        <a href="{{ route('projects.create') }}" class="text-blue-600 hover:underline">Crear el primero</a>
    </div>
@else
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
        @foreach($projects as $project)
            <a href="{{ route('projects.show', $project) }}" class="bg-white rounded-lg border border-gray-200 p-5 hover:shadow-md transition block">
                <div class="flex items-start justify-between gap-2">
                    <h2 class="font-semibold text-gray-800 mb-1">{{ $project->name }}</h2>
                    <span class="text-[11px] px-2 py-1 rounded-full bg-gray-100 text-gray-700">{{ $project->status_label }}</span>
                </div>
                @if($project->description)
                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $project->description }}</p>
                @endif
                <div class="flex items-center gap-4 text-xs text-gray-400">
                    <span>{{ $project->tasks_count }} tareas</span>
                    @if($project->deadline)
                        <span>Fecha limite: {{ $project->deadline->format('d/m/Y') }}</span>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
