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
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // Nome do ativo
            $table->enum('tipo', ['Carro', 'Caminhão']); // Tipo do ativo
            $table->string('modelo'); // Modelo do veículo
            $table->string('marca'); // Marca do veículo
            $table->string('placa')->unique(); // Placa do veículo (única)
            $table->integer('km_atual')->default(0); // KM Atual do veículo
            $table->timestamps(); // Criado em / Atualizado em
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
