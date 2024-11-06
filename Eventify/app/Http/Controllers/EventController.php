<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Store a newly created event in storage.
     */
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
                'organized_id' => 'required|integer',
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
    
            // Crear el evento en la base de datos
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
                'organized_id' => $request->organized_id,
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
}
