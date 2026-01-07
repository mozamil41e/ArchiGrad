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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->foreignId('supervisor_id')->constrained('supervisors')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('description');
            $table->enum('grade', ['A', 'B+', 'C+', 'C', 'F', 'pending'])->default('pending');
            $table->boolean('is_archiv')->default(false);
            $table->year('year')->nullable();
            $table->date('submission_deadline')->nullable();
            $table->string('path_file')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index('title');
            $table->index('description');
            $table->index('year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
