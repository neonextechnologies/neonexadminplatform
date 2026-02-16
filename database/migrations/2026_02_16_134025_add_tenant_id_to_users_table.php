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
        Schema::table('users', function (Blueprint $table) {
            // Phase 3: Add tenant_id for multi-tenancy (full implementation in Phase 5)
            $table->unsignedBigInteger('tenant_id')->nullable()->after('id')->index();
            
            // Phase 3: Make email unique per tenant (not globally unique)
            $table->dropUnique(['email']);
            $table->unique(['tenant_id', 'email'], 'users_tenant_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the composite unique constraint
            $table->dropUnique('users_tenant_email_unique');
            
            // Restore global email unique constraint
            $table->unique('email');
            
            // Drop tenant_id column
            $table->dropColumn('tenant_id');
        });
    }
};
