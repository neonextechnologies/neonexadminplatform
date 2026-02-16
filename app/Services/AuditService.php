<?php

namespace App\Services;

use App\Contracts\AuditContract;
use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * AuditService
 * 
 * Implementation of AuditContract.
 * Records audit logs for important system events (audit-first principle).
 * 
 * Usage:
 *   audit()->record('users.created', $user, ['email' => $user->email]);
 *   audit()->record('users.updated', $user, ['old' => $old, 'new' => $new]);
 *   audit()->record('users.deleted', $user);
 */
class AuditService implements AuditContract
{
    /**
     * Record an audit log entry
     * 
     * @param string $action Event name (e.g., 'users.created', 'roles.updated')
     * @param Model|string $subject The model being acted upon, or a string identifier
     * @param array $changes Key-value pairs of changes/data
     * @param array $metadata Additional context (correlation_id, ip, user_agent, etc.)
     * @return void
     */
    public function record(string $action, Model|string $subject, array $changes = [], array $metadata = []): void
    {
        $subjectType = null;
        $subjectId = null;

        if ($subject instanceof Model) {
            $subjectType = get_class($subject);
            $subjectId = (string) $subject->getKey();
        } elseif (is_string($subject)) {
            $subjectType = $subject;
        }

        $payload = array_merge($changes, $metadata);

        AuditLog::create([
            'tenant_id' => tenant_id(), // Uses stub from helpers.php (will be real in Phase 5)
            'actor_id' => Auth::id(),
            'event' => $action,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'payload' => $payload,
            'correlation_id' => $metadata['correlation_id'] ?? request()->header('X-Correlation-ID') ?? Str::uuid()->toString(),
        ]);

        // Also log to Laravel log for debugging
        logger()->info("Audit: {$action}", [
            'subject' => $subjectType,
            'subject_id' => $subjectId,
            'actor_id' => Auth::id(),
            'tenant_id' => tenant_id(),
        ]);
    }

    /**
     * Get audit logs for a specific model
     * 
     * @param Model $model
     * @param int $limit
     * @return array
     */
    public function for(Model $model, int $limit = 50): array
    {
        return AuditLog::query()
            ->where('subject_type', get_class($model))
            ->where('subject_id', (string) $model->getKey())
            ->where('tenant_id', tenant_id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    /**
     * Get audit logs by user
     * 
     * @param int $userId
     * @param int $limit
     * @return array
     */
    public function byUser(int $userId, int $limit = 50): array
    {
        return AuditLog::query()
            ->where('actor_id', $userId)
            ->where('tenant_id', tenant_id())
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->toArray();
    }
}
