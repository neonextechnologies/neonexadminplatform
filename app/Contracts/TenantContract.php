<?php

namespace App\Contracts;

/**
 * Tenant Contract
 * 
 * Tenant context resolver (tenant-first approach)
 * Provides current tenant context for all tenant-aware operations
 * 
 * Layer A: Contract only (implementations in Phase 5)
 */
interface TenantContract
{
    /**
     * Get current tenant ID
     * 
     * @return int|null
     */
    public function id(): ?int;

    /**
     * Get current tenant model
     * 
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function current(): ?\Illuminate\Database\Eloquent\Model;

    /**
     * Set current tenant
     * 
     * @param int|null $tenantId
     * @return void
     */
    public function set(?int $tenantId): void;

    /**
     * Check if tenant context is set
     * 
     * @return bool
     */
    public function hasContext(): bool;

    /**
     * Execute callback in tenant context
     * 
     * @param int $tenantId
     * @param callable $callback
     * @return mixed
     */
    public function runInContext(int $tenantId, callable $callback): mixed;
}
