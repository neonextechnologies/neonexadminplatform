<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * AuditLog Model
 * 
 * Stores audit trail for important system events.
 * Used by AuditService to record create/update/delete operations.
 * 
 * @property int $id
 * @property int|null $tenant_id
 * @property int|null $actor_id
 * @property string $event
 * @property string|null $subject_type
 * @property string|null $subject_id
 * @property array|null $payload
 * @property string|null $correlation_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AuditLog extends Model
{
    protected $fillable = [
        'tenant_id',
        'actor_id',
        'event',
        'subject_type',
        'subject_id',
        'payload',
        'correlation_id',
    ];

    protected $casts = [
        'payload' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the actor (user) who performed the action
     */
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }

    /**
     * Get the subject model (polymorphic)
     */
    public function subject()
    {
        return $this->morphTo('subject', 'subject_type', 'subject_id');
    }

    /**
     * Scope query to specific tenant
     */
    public function scopeForTenant($query, ?int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Scope query to specific event
     */
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope query to specific actor
     */
    public function scopeByActor($query, int $actorId)
    {
        return $query->where('actor_id', $actorId);
    }
}
