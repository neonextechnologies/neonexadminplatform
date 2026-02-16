<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Phase 8.1: Menu Items table
 * 
 * Individual menu items with nested support (parent_id)
 * Supports types: link (URL), route (Laravel named route), divider
 * Permission-based visibility, icon support, tenant-aware
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tenant_id')->index();
            $table->foreignId('menu_group_id')->constrained('menu_groups')->onDelete('cascade');
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('title');
            $table->string('type')->default('route'); // route, url, divider
            $table->string('url')->nullable();
            $table->string('route_name')->nullable();
            $table->string('icon')->nullable();
            $table->string('permission')->nullable(); // permission key for visibility
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable(); // extra data (target, badge, etc.)
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
