<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('thumbnail')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('genre')->nullable();
            $table->string('platform')->nullable();
            $table->string('publisher')->nullable();
            $table->string('developer')->nullable();
            $table->date('release_date')->nullable();
            $table->json('minimum_system_requirements')->nullable();
            $table->json('screenshots')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
