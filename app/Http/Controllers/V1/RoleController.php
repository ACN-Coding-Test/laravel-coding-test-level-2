<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Http\Requests\RoleRequest;
use Silber\Bouncer\Database\Role;
use App\Models\User;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::paginate();

        return new RoleCollection($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = new Role;
        $role->name = $request->input('name');
        $role->title = $request->input('title');
        $role->save();

        if (!empty($request->input('abilities'))) {
            $role->allow($request->input('abilities'));
        }

        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->json()->all());
        if (!empty($request->input('abilities'))) {
            foreach ($role->getAbilities() as $ability) {
                $role->disallow($ability->name);
            }
            $role->allow($request->input('abilities'));
        } else {
            foreach ($role->getAbilities() as $ability) {
                $role->disallow($ability->name);
            }
        }

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return new RoleResource($role);
    }

    public function assignRole(Request $request, User $user)
    {
        if (!empty($request->input('roles'))) {
            foreach ($user->roles as $role) {
                $user->retract($role);
            }
            foreach ($request->input('roles') as $role) {
                $user->assign($role);
            }
        }

        return new RoleResource($user);
    }
}
