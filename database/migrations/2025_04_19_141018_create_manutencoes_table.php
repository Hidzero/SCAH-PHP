<?php

// database/migrations/2025_04_18_000000_create_manutencoes_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('manutencoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retirada_id')
                ->constrained('retiradas')
                ->onDelete('cascade');
            $table->date('data_retorno');
            $table->date('data_conserto')->nullable();
            $table->text('descricao')->nullable();
            $table->enum('status', ['aguardando peça', 'em conserto', 'condenado', 'voltar para estoque'])
                ->default('aguardando peça');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencoes');
    }
};