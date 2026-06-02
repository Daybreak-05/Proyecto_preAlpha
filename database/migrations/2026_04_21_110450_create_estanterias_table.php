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
        // Comando: php artisan make:migration create_estanterias_table
        Schema::create('estanterias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Ej: "Pasillo 1 - Lácteos"
            $table->integer('x');      // Posición horizontal en el SVG
            $table->integer('y');      // Posición vertical en el SVG
            $table->integer('ancho');  // Ancho del rectángulo
            $table->integer('alto');   // Alto del rectángulo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estanterias');
    }
};
