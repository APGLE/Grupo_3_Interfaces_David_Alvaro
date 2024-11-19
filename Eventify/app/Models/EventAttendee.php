<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventAttendee extends Model
{
    use HasFactory;

    protected $table = 'event_attendees';

    protected $fillable = [
        'event_id',
        'user_id',
        'status',
        'register_at',
        'deleted',
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;
}
