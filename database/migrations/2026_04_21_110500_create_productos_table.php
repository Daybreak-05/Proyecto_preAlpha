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
    // Comando: php artisan make:migration create_productos_table
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('codigo_barras')->unique();
        $table->integer('stock_actual');
        $table->integer('stock_minimo'); // Para alertas de reposición
        $table->date('fecha_caducidad');
        $table->decimal('precio', 8, 2);
        
        // Relación con estantería (Clave Foránea)
        $table->foreignId('estanteria_id')
            ->constrained('estanterias')
            ->onDelete('cascade'); 
            
        // Relación con proveedor
        $table->foreignId('proveedor_id')
            ->constrained('proveedores');

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
