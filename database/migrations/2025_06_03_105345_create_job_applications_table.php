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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->text('picture');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('birth_location');
            $table->date('date_of_birth');
            $table->json('address');
            $table->text('summary');
            $table->json('experiences')->nullable();
            $table->json('educations');
            $table->json('skills');
            $table->json('extra_info')->nullable();
            $table->string('from');
            $table->string('company_name');
            $table->string('company_address');
            $table->string('position');
            $table->json('documents');
            $table->enum('sent_type', ['online', 'offline']);
            $table->text('signature');
            $table->enum('status', [
                'draft',
                'sent',
                'interviewed',
                'rejected',
                'hired',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
