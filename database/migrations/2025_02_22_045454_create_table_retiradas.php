<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa a migration.
     */
    public function up(): void
    {
        Schema::create('retiradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ferramenta_id')->constrained('ferramentas')->onDelete('cascade');
            $table->foreignId('responsavel_id')->constrained('users')->onDelete('cascade');
            $table->date('previsao_retorno');
            $table->boolean('uso_interno')->default(false);
            $table->foreignId('obra_id')->nullable()->constrained('obras')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverte a migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('retiradas');
    }
};
