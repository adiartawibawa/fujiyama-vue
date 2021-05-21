<?php

namespace App\Http\Controllers\Roles;

use Inertia\Inertia;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use App\Http\Resources\Role\RoleResource;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\Roles as RoleCollection;
use App\Http\Resources\Permission\Permissions as PermissionCollection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('manage-user')) {
            return abort(401);
        }

        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name'],
        ]);

        $query = Role::query();
        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        $roles = $query->paginate();

        return Inertia('Role/Index', [
            'roles' => new RoleCollection($roles),
            'filters' => request()->all(['search', 'field', 'direction']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Gate::allows('manage-user')) {
            return abort(401);
        }

        $permissions = Permission::all();

        return Inertia::render('Role/Create', [
            'permissions' => fn () => new PermissionCollection($permissions),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        if (!Gate::allows('manage-user')) {
            return abort(401);
        }

        $role = Role::create([
            'guard_name' => 'web',
            'name' => Str::kebab($request->input('name')),
        ]);

        $permissions = $request->input('permissions') ? $request->input('permissions') : [];
        if ($permissions != null) {
            foreach ($permissions as $item) {
                $role->givePermissionTo($item);
            }
        }

        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if (!Gate::allows('manage-user')) {
            return abort(401);
        }

        $permissions = Permission::all();

        return Inertia::render('Role/Edit', [
            'role' => new RoleResource($role),
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        if (!Gate::allows('manage-user')) {
            return abort(401);
        }

        $role->update($request->all());

        // sync the role with the new permission
        $permissions = $request->input('permissions') ? $request->input('permissions') : [];
        $role->syncPermissions($permissions);

        return redirect()->route('role.index')
            ->with([
                'message' => [
                    'message' => 'Role has been updated',
                    'type' => 'success'
                ]
            ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (!Gate::allows('manage-user')) {
            return abort(401);
        }

        $role->delete();

        return redirect()->route('role.index');
    }
}
