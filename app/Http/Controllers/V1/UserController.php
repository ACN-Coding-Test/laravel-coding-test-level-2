<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Auth\Access\AuthorizationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all();

            return response(
                $users
            );
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = User::create(
                [
                    'username' => $request->input('username'),
                    'password' => bcrypt($request->input('password')),
                    'role_id' => $request->input('role_id'),
                ]
            );

            return response($user);
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            return response(
                $user
            );
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(EditUserRequest $request, $id)
    {
        try {
            $user = User::find($id);

            if(!$user) {
                return response(
                    [
                        'errors' => 'The requested User is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $user->username = $request->input('username');
            $user->password = bcrypt($request->input('password'));
            $user->role_id = $request->input('role_id');

            $user->update();

            return response($user);
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::find($id);

            if(!$user) {
                return response(
                    [
                        'errors' => 'The requested User is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $user->username = $request->input('username');
            $user->password = bcrypt($request->input('password'));
            $user->role_id = $request->input('role_id');

            $user->update();

            return response($user);
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if(!$user) {
                return response(
                    [
                        'errors' => 'The requested User is not found'
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }

            $user->delete();

            return response(
                [
                    'message' => 'This user deleted successfully'
                ],
                Response::HTTP_OK
            );
        } catch (AuthorizationException  $ex) {
            return response(
                [
                    'errors' => $ex->getMessage()
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
