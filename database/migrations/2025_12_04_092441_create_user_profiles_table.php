<?php

use App\Models\User;
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
        // TODO: add constraints to all migrations so far -> cascade on delete
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('location')->nullable();
            $table->string('gender')->default('hidden');
            $table->datetime('date_of_birth')->nullable();
            $table->boolean('show_profile')->default(true);
            $table->boolean('show_online_status')->default(true);
            $table->boolean('show_comments')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
