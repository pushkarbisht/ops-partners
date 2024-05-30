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
         Schema::create('professional_network', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('following_user_id')->nullable();
            $table->string('PermanentAddress', 255)->nullable();
            $table->string('Position', 100)->nullable();
            $table->string('Skills', 255)->nullable();
            $table->string('Portfolio', 255)->nullable();
            $table->string('LinkedInURL', 255)->nullable();
            $table->text('SkillsToExplore')->nullable();
            $table->string('ModeOfWork', 20)->nullable();
            $table->string('Purpose', 255)->nullable();
            $table->text('InterestsHobbies')->nullable();
            $table->string('Type', 255)->nullable();
            $table->string('ResumeFile', 10)->nullable();
            $table->string('delete_status', 255)->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('following_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_network');
    }
};
