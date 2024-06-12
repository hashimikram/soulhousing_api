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
        Schema::create('list_options', function (Blueprint $table) {
            $table->id();
            $table->string('list_id');
            $table->string('option_id');
            $table->string('title');
            $table->string('sequence')->default('0');
            $table->string('is_default')->default('0');
            $table->string('option_value')->default('0');
            $table->string('mapping')->nullable();
            $table->longText('notes')->nullable();
            $table->string('codes')->nullable();
            $table->string('toggle_setting_1')->nullable();
            $table->string('toggle_setting_2')->nullable();
            $table->string('activity')->nullable();
            $table->string('subtype')->nullable();
            $table->string('edit_options')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_options');
    }
};
