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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained(); // Links to the problem type (Plumbing, IT, etc)
            
            // 🚨 THE SPECIFIC UNIVERSITY LOCATION 🚨
            $table->string('building');          // e.g., "Abay Building"
            $table->string('floor')->nullable(); // e.g., "1st Floor"
            $table->string('specific_location'); // e.g., "Right-side male toilet"
            
            $table->string('subject');
            $table->text('description');
            
            // Evidence & Resolution
            $table->string('evidence_path')->nullable();            // Photo of the broken thing
            $table->string('resolution_evidence_path')->nullable(); // Photo of the fixed thing
            
            // System Tracking
            $table->string('status')->default('open'); // open, assigned, in_progress, resolved, closed
            $table->string('priority')->default('medium');
            
            // 🚨 ASSIGNED TO TECHNICIAN 🚨
            $table->foreignId('assigned_technician_id')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamp('eta_timestamp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
