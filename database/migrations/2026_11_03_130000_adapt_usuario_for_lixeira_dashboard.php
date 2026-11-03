<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('cpf')->nullable()->change();
            $table->date('data_nascimento')->nullable()->change();
            $table->string('telefone')->nullable();
            $table->string('tipo_usuario')->default('morador');
        });

        Schema::create('lixeiras', function (Blueprint $table) {
            $table->string('tipo')->primary();
            $table->string('nome');
            $table->string('cor', 7);
            $table->boolean('aberta')->default(false);
            $table->foreignId('atualizada_por')->nullable()->constrained('usuario')->nullOnDelete();
            $table->timestamps();
        });

        DB::table('lixeiras')->insert([
            ['tipo' => 'organico', 'nome' => 'Orgânico', 'cor' => '#16864b', 'aberta' => true, 'created_at' => now(), 'updated_at' => now()],
            ['tipo' => 'metal', 'nome' => 'Metal', 'cor' => '#f4bf18', 'aberta' => false, 'created_at' => now(), 'updated_at' => now()],
            ['tipo' => 'plastico', 'nome' => 'Plástico', 'cor' => '#ef3935', 'aberta' => true, 'created_at' => now(), 'updated_at' => now()],
            ['tipo' => 'papel', 'nome' => 'Papel', 'cor' => '#1685d8', 'aberta' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('lixeiras');

        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn(['telefone', 'tipo_usuario']);
        });
    }
};
