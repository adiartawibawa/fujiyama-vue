<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\Role\Roles as RoleCollection;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\User\Users as UserCollection;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:manage-user']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => ['in:asc,desc'],
            'field' => ['in:name'],
        ]);

        $query = User::query();
        if (request('search')) {
            $query->where('name', 'LIKE', '%' . request('search') . '%')
                ->orWhere('email', 'LIKE', '%' . request('search') . '%');
        }

        if (request()->has(['field', 'direction'])) {
            $query->orderBy(request('field'), request('direction'));
        }

        $users = $query->paginate();

        return Inertia('User/Index', [
            'users' => new UserCollection($users),
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
        $roles = Role::get();
        return Inertia::render('User/Create', [
            'roles' => new RoleCollection($roles),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->assignRole(Str::kebab($roles['name']));

        return redirect()->route('user.index')->with([
            'message' => [
                'message' => 'User has been created',
                'type' => 'success'
            ]
        ]);
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
    public function edit(User $user)
    {
        $roles = Role::all();
        return Inertia::render('User/Edit', [
            'user' => new UserResource($user),
            'roles' => new RoleCollection($roles),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());

        $roles = $request->input('roles') ? $request->input('roles') : [];
        $user->syncRoles($roles['name']);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }

    /**
     * Restore the spesified resource from storage
     *
     * @param  mixed $user
     * @return void
     */
    public function restore(User $user)
    {
        $user->restore();

        return redirect()->route('user.index');
    }
}
