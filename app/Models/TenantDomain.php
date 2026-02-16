<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * TenantDomain Model
 * 
 * Phase 5: Multi-tenancy tenant resolution
 * Supports domain, subdomain, and path-based tenant resolution.
 * 
 * @property int $id
 * @property int $tenant_id
 * @property string|null $domain
 * @property string|null $subdomain
 * @property string|null $path
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class TenantDomain extends Model
{
    protected $fillable = [
        'tenant_id',
        'domain',
        'subdomain',
        'path',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the tenant that owns this domain
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Scope query by full domain
     */
    public function scopeByDomain($query, string $domain)
    {
        return $query->where('domain', $domain);
    }

    /**
     * Scope query by subdomain
     */
    public function scopeBySubdomain($query, string $subdomain)
    {
        return $query->where('subdomain', $subdomain);
    }

    /**
     * Scope query by path
     */
    public function scopeByPath($query, string $path)
    {
        return $query->where('path', $path);
    }

    /**
     * Get resolution method used
     */
    public function getResolutionMethodAttribute(): string
    {
        if ($this->domain) {
            return 'domain';
        }
        if ($this->subdomain) {
            return 'subdomain';
        }
        if ($this->path) {
            return 'path';
        }
        return 'unknown';
    }
}
