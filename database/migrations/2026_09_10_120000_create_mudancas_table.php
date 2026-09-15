<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mudancas', function (Blueprint $table) {
            $table->id();
            $table->string('material', 120);
            $table->text('justificativa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mudancas');
    }
};
