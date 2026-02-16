<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Role Model
 * 
 * Phase 2: RBAC minimal implementation
 * Audit-first: Role changes should be audited (Phase 3+)
 * 
 * @property int $id
 * @property string $name
 * @property string|null $label
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read \Illuminate\Database\Eloquent\Collection<Permission> $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection<User> $users
 */
class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    /**
     * Get the permissions assigned to this role
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role')
            ->withTimestamps();
    }

    /**
     * Get the users with this role
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Assign a permission to this role
     *
     * @param Permission|string $permission
     * @return void
     */
    public function givePermission(Permission|string $permission): void
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }

        if (!$this->permissions->contains($permission->id)) {
            $this->permissions()->attach($permission);
        }
    }

    /**
     * Check if role has a specific permission
     *
     * @param string $permissionName
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()
            ->where('name', $permissionName)
            ->exists();
    }
}
