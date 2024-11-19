<!DOCTYPE html>
<html>
<head>
    <title>{{ $titulo }}</title>
</head>
<body>
    <h1>{{ $titulo }}</h1>
    <p>{{ $contenido }}</p>
    
    @if($events->isNotEmpty())
        <ul>
            @foreach($events as $event)
                <li>
                    <strong>{{ $event->title }}</strong><br>
                    <strong>Ubicación:</strong> {{ $event->location }}<br>
                    <strong>Inicio:</strong> {{ \Carbon\Carbon::parse($event->start_time)->format('d M Y, h:i A') }}<br>
                    <strong>Fin:</strong> {{ \Carbon\Carbon::parse($event->end_time)->format('d M Y, h:i A') }}<br>
                    <strong>Precio:</strong> ${{ number_format($event->price, 2) }}<br><br>
                </li>
            @endforeach
        </ul>
    @else
        <p>No estás inscrito en ningún evento.</p>
    @endif
</body>
</html>
