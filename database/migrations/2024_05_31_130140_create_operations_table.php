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
        Schema::create('operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('CASCADE');
            $table->timestamp('date');
            $table->text('body');
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->string('likes')->default('0');
            $table->string('comments')->default('0');
            $table->string('share')->default('0');
            $table->text('comment')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operations');
    }
};
