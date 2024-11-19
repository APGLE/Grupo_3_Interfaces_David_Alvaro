<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\EventAttendee;



class EventController extends Controller
{

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'category_id' => 'required|integer',
                'description' => 'required|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'location' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'price' => 'nullable|numeric',
                'max_attendees' => 'nullable|integer',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Verificar si la validación falla
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Manejo de la carga de la imagen
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
            }

            // Crear el evento en la base de datos con el ID del usuario autenticado como organized_id
            $event = Event::create([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'latitude' => $request->latitude ?? 0.0,
                'longitude' => $request->longitude ?? 0.0,
                'price' => $request->price ?? 0.0,
                'max_attendees' => $request->max_attendees ?? 0,
                'organized_id' => auth()->id(),  // Asignar el ID del usuario autenticado
                'image_url' => $imageName,
                'deleted' => 0,
            ]);

            // Confirmación de creación de evento
            return response()->json(['message' => 'Evento creado exitosamente'], 201);
        } catch (\Exception $e) {
            \Log::error("Error al guardar el evento: " . $e->getMessage());
            return response()->json(['message' => 'Error en el servidor.' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());

        return redirect()->route('home')->with('success', 'Evento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id); 
        $event->delete(); 

        return redirect()->route('home')->with('success', 'Evento eliminado exitosamente.');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
    }
    public function musica()
{
    $eventos = Event::where('category_id', 1)->get();
    return view('home', ['events' => $eventos, 'categoria' => 'Música']);
}

public function deporte()
{
    $eventos = Event::where('category_id', 2)->get();
    return view('home', ['events' => $eventos, 'categoria' => 'Deporte']);
}

public function tecnologia()
{
    $eventos = Event::where('category_id', 3)->get();
    return view('home', ['events' => $eventos, 'categoria' => 'Tecnología']);
}

public function subscribe($eventId)
    {
        $userId = auth()->user()->id;

        $attendee = EventAttendee::where('event_id', $eventId)
                                 ->where('user_id', $userId)
                                 ->where('deleted', 0)
                                 ->first();

        if (!$attendee) {
            EventAttendee::create([
                'event_id' => $eventId,
                'user_id' => $userId,
                'status' => 'CONFIRMED',
                'register_at' => now(),
                'deleted' => 0, 
            ]);
        }

        return back();
    }

    public function unsubscribe($eventId)
    {
        $userId = auth()->user()->id;

        $attendee = EventAttendee::where('event_id', $eventId)
                                 ->where('user_id', $userId)
                                 ->where('deleted', 0)
                                 ->first();

        if ($attendee) {
            $attendee->update(['deleted' => 1, 'status' => 'CANCELLED']);
        }

        return back(); 
    }


}
