<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'description' => 'required|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price' => 'nullable|numeric',
            'max_attendees' => 'nullable|integer',
            'organized_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Manejo de la carga de la imagen
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        // Guardar los datos en la base de datos
        $event = new Event();
        $event->title = $request->input('title');
        $event->category_id = $request->input('category_id');
        $event->description = $request->input('description');
        $event->start_time = $request->input('start_time');
        $event->end_time = $request->input('end_time');
        $event->location = $request->input('location');
        $event->latitude = $request->input('latitude');
        $event->longitude = $request->input('longitude');
        $event->price = $request->input('price');
        $event->max_attendees = $request->input('max_attendees');
        $event->organized_id = $request->input('organized_id');
        $event->image_url = $imageName;
        $event->save();

        return response()->json(['message' => 'Evento creado con éxito'], 200);
    }
}
