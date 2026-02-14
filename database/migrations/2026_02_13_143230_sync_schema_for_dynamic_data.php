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
        Schema::table('services', function (Blueprint $table) {
            $table->string('color')->nullable()->after('description');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('content', 'feedback');
            $table->renameColumn('avatar_url', 'image_url');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('color');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->renameColumn('feedback', 'content');
            $table->renameColumn('image_url', 'avatar_url');
        });
    }
};
