<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Setting Model
 * 
 * Phase 4: Tenant-aware settings storage
 * Used by SettingService for cache-first config management.
 * 
 * @property int $id
 * @property int|null $tenant_id
 * @property string $group
 * @property string $key
 * @property string|null $value
 * @property string $type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Setting extends Model
{
    protected $fillable = [
        'tenant_id',
        'group',
        'key',
        'value',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the decoded value based on type
     * 
     * @return mixed
     */
    public function getDecodedValueAttribute()
    {
        return match($this->type) {
            'json' => json_decode($this->value, true),
            'int' => (int) $this->value,
            'bool' => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            'float' => (float) $this->value,
            default => $this->value,
        };
    }

    /**
     * Set value with automatic type encoding
     * 
     * @param mixed $value
     * @return void
     */
    public function setEncodedValue($value): void
    {
        if (is_array($value) || is_object($value)) {
            $this->type = 'json';
            $this->value = json_encode($value);
        } elseif (is_bool($value)) {
            $this->type = 'bool';
            $this->value = $value ? '1' : '0';
        } elseif (is_int($value)) {
            $this->type = 'int';
            $this->value = (string) $value;
        } elseif (is_float($value)) {
            $this->type = 'float';
            $this->value = (string) $value;
        } else {
            $this->type = 'string';
            $this->value = (string) $value;
        }
    }

    /**
     * Scope query to specific tenant
     */
    public function scopeForTenant($query, ?int $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    /**
     * Scope query to specific group
     */
    public function scopeForGroup($query, string $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope query to specific key
     */
    public function scopeForKey($query, string $key)
    {
        return $query->where('key', $key);
    }
}
