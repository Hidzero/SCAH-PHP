<?php

// database/migrations/2025_04_27_000001_create_saidas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('saidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')
                  ->constrained('veiculos')
                  ->onDelete('cascade');
            $table->foreignId('motorista_id')
                  ->constrained('motoristas')
                  ->onDelete('cascade');
            $table->integer('km_atual');
            $table->text('avarias_descritas')->nullable();
            $table->text('nota_retorno')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saidas');
    }
};