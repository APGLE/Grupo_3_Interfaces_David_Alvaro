<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'start_time',
        'end_time',
        'location',
        'latitude',
        'longitude',
        'price',
        'max_attendees',
        'organized_id',
        'image_url'
    ];
}
