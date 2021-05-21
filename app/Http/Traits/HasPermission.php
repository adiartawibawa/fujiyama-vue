<?php

namespace App\Http\Traits;

use App\Models\Permission;
use App\Models\Role;

trait HasPermission
{

    /**
     * handling role relation
     *
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * handling permissions relation
     *
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user');
    }

    /**
     * Iterating through the roles and checking by the slug field, if that specific role exists.
     *
     * @param  mixed $roles
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checking Permissions
     * User may have individual Permission for some actions.
     *
     * @param  mixed $permission
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }

    /**
     *  iterating through each permission associated with a role, 
     *   we’ve a many to many relationship setup between roles and permissions table.
     *
     * @param  mixed $permission
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checking Permissions
     * User may have individual Permission for some actions.
     *
     * @param  mixed $permission
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Give a set of permissions to a logged in user,
     *
     * @param  mixed $permissions
     * @return void
     */
    public function givePermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return $this;
    }

    /**
     * deleting or removing permissions from the user scope
     *
     * @param  mixed $permissions
     */
    public function withdrawPermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);

        $this->permissions()->detach($permissions);

        return $this;
    }

    /**
     * We'll need to refresh the permission from user scope
     * we will detach first and then we giving the permission again
     *
     * @param  mixed $permissions
     * @return void
     */
    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionsTo($permissions);
    }

    /**
     * Getting all the permission from the user scope
     *
     * @param  mixed $permissions
     * @return void
     */
    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }
}
