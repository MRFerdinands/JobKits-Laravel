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
        Schema::create('curriculum_vitaes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('picture');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('birth_location');
            $table->date('date_of_birth');
            $table->text('address');
            $table->text('summary');
            $table->json('experiences')->nullable();
            $table->json('educations');
            $table->json('skills');
            $table->json('extra_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_vitaes');
    }
};
