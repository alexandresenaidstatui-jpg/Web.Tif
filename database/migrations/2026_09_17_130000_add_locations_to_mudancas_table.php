<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mudancas', function (Blueprint $table) {
            $table->string('origem')->after('id');
            $table->string('destino')->after('origem');
        });
    }

    public function down(): void
    {
        Schema::table('mudancas', function (Blueprint $table) {
            $table->dropColumn(['origem', 'destino']);
        });
    }
};