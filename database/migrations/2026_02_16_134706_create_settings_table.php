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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->nullable()->index()->comment('Tenant scope (Phase 5)');
            $table->string('group')->default('app')->index()->comment('Setting group (app, theme, i18n, etc.)');
            $table->string('key')->index()->comment('Setting key');
            $table->longText('value')->nullable()->comment('Setting value (JSON or string)');
            $table->string('type')->default('string')->comment('Value type: string, json, int, bool');
            $table->timestamps();

            // Unique constraint: tenant + group + key
            $table->unique(['tenant_id', 'group', 'key'], 'settings_tenant_group_key_unique');
            
            // Composite index for common queries
            $table->index(['tenant_id', 'group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
