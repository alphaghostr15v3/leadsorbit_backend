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
        Schema::create('team_members', function (Blueprint $image) {
            $image->id();
            $image->string('name');
            $image->string('role');
            $image->string('image_url')->nullable();
            $image->text('bio')->nullable();
            $image->string('linkedin')->nullable();
            $image->string('twitter')->nullable();
            $image->string('github')->nullable();
            $image->integer('order')->default(0);
            $image->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
