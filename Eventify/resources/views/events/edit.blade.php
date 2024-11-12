@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Evento</h1>
    
    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Campos existentes -->
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" id="title" value="{{ $event->title }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{ $event->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Ubicación</label>
            <input type="text" name="location" class="form-control" id="location" value="{{ $event->location }}" required>
        </div>

        <!-- Campos adicionales para precio y cantidad de personas -->
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" name="price" class="form-control" id="price" value="{{ $event->price }}" required>
        </div>
        <div class="mb-3">
            <label for="max_attendees" class="form-label">Cantidad de Personas</label>
            <input type="number" name="max_attendees" class="form-control" id="max_attendees" value="{{ $event->max_attendees }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
@endsection
