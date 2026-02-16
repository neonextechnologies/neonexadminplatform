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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable()->index()->comment('Tenant scope (from Phase 5)');
            $table->unsignedBigInteger('actor_id')->nullable()->index()->comment('User who performed the action');
            $table->string('event', 120)->index()->comment('Event name (e.g., users.created)');
            $table->string('subject_type', 120)->nullable()->comment('Model class name');
            $table->string('subject_id', 64)->nullable()->comment('Model primary key');
            $table->json('payload')->nullable()->comment('Additional context/changes');
            $table->string('correlation_id', 64)->nullable()->index()->comment('Request correlation ID');
            $table->timestamps();

            // Composite index for common queries
            $table->index(['tenant_id', 'event', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
