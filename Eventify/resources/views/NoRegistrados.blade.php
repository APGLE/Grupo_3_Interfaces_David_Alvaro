@extends('layouts.app')

@section('content')
    <h3>Eventos No Registrados</h3>
    
    @if($eventosNoRegistrados->isEmpty())
        <p>No hay eventos disponibles para registrarse.</p>
    @else
        <div class="container mt-5">
            <div class="row">
                @foreach ($eventosNoRegistrados as $evento)
                    <div class="col-md-4 mb-4">
                        <div class="card evento-card">
                            <img src="{{ asset('storage/' . $evento->image_url) }}" class="card-img-top" alt="{{ $evento->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $evento->title }}</h5>
                                <p class="card-text"><strong>Organizador:</strong> {{ $evento->organizer_name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

@endsection

@section('styles')
    <style>
        .evento-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .evento-card img {
            object-fit: cover;
            height: 200px;
            width: 100%;
        }

        .evento-card .card-body {
            padding: 15px;
        }

        .evento-card .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .evento-card .card-text {
            font-size: 1rem;
            color: #555;
        }

        .evento-card .card-text strong {
            color: #333;
        }

        .container {
            max-width: 1200px;
        }

        h3 {
            margin-bottom: 30px;
        }
    </style>
@endsection
