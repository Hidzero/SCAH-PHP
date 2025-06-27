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
        Schema::table('users', function (Blueprint $table) {
            // Alterar o ENUM da coluna 'role'
            DB::statement("ALTER TABLE users MODIFY role ENUM('master','admin','estoque','manutencao','veiculos') NOT NULL DEFAULT 'estoque'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverter para os valores antigos
            DB::statement("ALTER TABLE users MODIFY role ENUM('master','admin','usuario') NOT NULL DEFAULT 'usuario'");
        });
    }
};
