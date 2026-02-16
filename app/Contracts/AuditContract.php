<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Audit Contract
 * 
 * Central audit logging interface (audit-first approach)
 * All important CRUD operations MUST call audit()->record()
 * 
 * Layer A: Contract only (implementations in Phase 3+)
 */
interface AuditContract
{
    /**
     * Record an audit event
     * 
     * @param string $action Action type (created, updated, deleted, viewed, etc.)
     * @param Model|string $subject The model instance or class name
     * @param array $changes Changed attributes (for updates)
     * @param array $metadata Additional metadata
     * @return void
     */
    public function record(
        string $action,
        Model|string $subject,
        array $changes = [],
        array $metadata = []
    ): void;

    /**
     * Get audit logs for a model
     * 
     * @param Model $model
     * @param int $limit
     * @return array
     */
    public function for(Model $model, int $limit = 50): array;

    /**
     * Get audit logs by user
     * 
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function byUser(int $userId, int $limit = 50): array;
}
