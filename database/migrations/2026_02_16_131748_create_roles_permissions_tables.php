<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * RBAC Tables Migration
 * 
 * Phase 2: Minimal roles & permissions tables
 * Registry-first: Permissions must be registered via PermissionRegistry
 * Audit-first: Role/permission changes will be audited
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Role slug (e.g., admin, user)');
            $table->string('label')->nullable()->comment('Human-readable role name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // Permissions table
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('Permission slug (e.g., users.view)');
            $table->string('group')->default('general')->comment('Permission group for organization');
            $table->string('label')->nullable()->comment('Human-readable permission name');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->index('group');
        });

        // Role-User pivot (many-to-many)
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->primary(['role_id', 'user_id']);
        });

        // Permission-Role pivot (many-to-many)
        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            
            $table->primary(['permission_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }
};
