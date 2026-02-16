<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Permission Model
 * 
 * Phase 2: RBAC minimal implementation
 * Registry-first: Permissions MUST be registered via PermissionRegistry before use
 * Audit-first: Permission changes should be audited (Phase 3+)
 * 
 * @property int $id
 * @property string $name
 * @property string $group
 * @property string|null $label
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<Role> $roles
 */
class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'group',
        'label',
        'description',
    ];

    /**
     * Get the roles that have this permission
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_role')
            ->withTimestamps();
    }

    /**
     * Assign this permission to a role
     *
     * @param Role|string $role
     * @return void
     */
    public function assignToRole(Role|string $role): void
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->firstOrFail();
        }

        if (!$this->roles->contains($role->id)) {
            $this->roles()->attach($role);
        }
    }
}
