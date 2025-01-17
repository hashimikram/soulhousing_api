<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cpt_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('category')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index('code');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpt_codes');
    }
};
