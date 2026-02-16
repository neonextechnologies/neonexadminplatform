<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Tenant Model
 * 
 * Phase 5: Multi-tenancy support
 * Represents a single tenant in the system.
 * 
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property bool $is_active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Tenant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant domains (multiple resolution methods)
     */
    public function domains(): HasMany
    {
        return $this->hasMany(TenantDomain::class);
    }

    /**
     * Get users associated with this tenant
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user')
            ->withTimestamps();
    }

    /**
     * Get settings for this tenant
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    /**
     * Scope query to active tenants
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope query by slug
     */
    public function scopeBySlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * Check if user has access to this tenant
     */
    public function hasUser(int $userId): bool
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    /**
     * Add user to tenant
     */
    public function addUser(int $userId): void
    {
        if (!$this->hasUser($userId)) {
            $this->users()->attach($userId);
            
            // Audit-first: Log user added to tenant
            audit()->record('tenants.user_added', $this, [
                'user_id' => $userId,
                'tenant_id' => $this->id,
            ]);
        }
    }

    /**
     * Remove user from tenant
     */
    public function removeUser(int $userId): void
    {
        if ($this->hasUser($userId)) {
            $this->users()->detach($userId);
            
            // Audit-first: Log user removed from tenant
            audit()->record('tenants.user_removed', $this, [
                'user_id' => $userId,
                'tenant_id' => $this->id,
            ]);
        }
    }
}
