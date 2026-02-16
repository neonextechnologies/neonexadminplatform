<?php

namespace App\Services;

use App\Contracts\TenantContract;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Model;

/**
 * TenantService
 * 
 * Phase 5: Tenant resolver and context management
 * Implements TenantContract for stable tenant context per request.
 * 
 * Usage:
 *   $tenantId = app('tenant')->id();
 *   $tenant = app('tenant')->current();
 */
class TenantService implements TenantContract
{
    /**
     * Current tenant ID
     */
    protected ?int $tenantId = null;

    /**
     * Current tenant model instance
     */
    protected ?Tenant $tenant = null;

    /**
     * Get current tenant ID
     * 
     * @return int|null
     */
    public function id(): ?int
    {
        return $this->tenantId;
    }

    /**
     * Get current tenant model
     * 
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function current(): ?Model
    {
        if ($this->tenant === null && $this->tenantId !== null) {
            $this->tenant = Tenant::find($this->tenantId);
        }

        return $this->tenant;
    }

    /**
     * Set current tenant ID
     * 
     * @param int|null $tenantId
     * @return void
     */
    public function set(?int $tenantId): void
    {
        $this->tenantId = $tenantId;
        $this->tenant = null; // Reset cached tenant
        
        // Store in app container for global access
        app()->instance('tenant.id', $tenantId);
        
        // Store in session for persistence
        if ($tenantId) {
            session()->put('tenant_id', $tenantId);
        } else {
            session()->forget('tenant_id');
        }
    }

    /**
     * Check if tenant context is set
     * 
     * @return bool
     */
    public function hasContext(): bool
    {
        return $this->tenantId !== null;
    }

    /**
     * Run callback within specific tenant context
     * 
     * @param int $tenantId
     * @param callable $callback
     * @return mixed
     */
    public function runInContext(int $tenantId, callable $callback): mixed
    {
        $originalTenantId = $this->tenantId;
        
        try {
            $this->set($tenantId);
            return $callback();
        } finally {
            $this->set($originalTenantId);
        }
    }

    /**
     * Load tenant from session (for subsequent requests)
     * 
     * @return void
     */
    public function loadFromSession(): void
    {
        $sessionTenantId = session('tenant_id');
        
        if ($sessionTenantId) {
            $this->set($sessionTenantId);
        }
    }

    /**
     * Clear tenant context
     * 
     * @return void
     */
    public function clear(): void
    {
        $this->set(null);
    }

    /**
     * Check if user has access to current tenant
     * 
     * @param int $userId
     * @return bool
     */
    public function userHasAccess(int $userId): bool
    {
        if (!$this->hasContext()) {
            return false;
        }

        $tenant = $this->current();
        
        if (!$tenant) {
            return false;
        }

        return $tenant->hasUser($userId);
    }
}
