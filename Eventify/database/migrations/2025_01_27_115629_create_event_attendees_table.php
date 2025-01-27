<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade'); // Relación con eventos
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');   // Relación con usuarios
            $table->string('status'); // Estado del registro (CONFIRMED, CANCELLED, etc.)
            $table->timestamp('register_at')->nullable(); // Fecha de registro
            $table->boolean('deleted')->default(false); // Borrado lógico
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_attendees');
    }
};
