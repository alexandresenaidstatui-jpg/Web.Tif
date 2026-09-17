<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('funcionario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('registro_funcionario')->unique();
            $table->string('materias')->nullable();
            $table->date('data_nascimento');
            $table->string('senha');
            $table->timestamps();
        });

        Schema::create('token_funcionario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funcionario_id')->constrained('funcionario')->cascadeOnDelete();
            $table->string('token')->unique();
            $table->timestamp('valido_ate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_funcionario');
        Schema::dropIfExists('funcionario');
    }
};