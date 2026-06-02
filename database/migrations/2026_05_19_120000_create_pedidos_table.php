<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->timestamp('fecha')->nullable();
            $table->string('metodo_pago')->nullable();
            $table->string('correo')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('estado')->default('Pendiente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pedidos');
    }
};
