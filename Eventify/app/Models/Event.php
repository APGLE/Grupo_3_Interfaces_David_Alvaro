<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

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


    public function attendees()
    {
        return $this->hasMany(EventAttendee::class, 'event_id');
    }


}
