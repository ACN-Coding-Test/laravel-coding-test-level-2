<?php
namespace App\Http\Controllers\Api\V1;
use App\Models\User;
use App\Http\Controllers\Api\V1\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    public function index()
    {
        $Users = User::all();
        return new UserResource($Users);
    }

    public function show($id)
    {
        $user = User::find($id);
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $this->middleware('CheckBlackList');
        $data = $request->all();
        $validator = Validator::make($data, [
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        
        $data['username'] = $data['username'];

        $data['password'] = Hash::make($data['password']);
        $User = User::create($data);
        return new UserResource($User);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        $validator = Validator::make($data, [
            'username' => 'required|unique:users,username,'.$id,
            'password' => 'required|min:6',
        ]);

        

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $data['password'] = Hash::make($data['password']);

        $user->update($data);
        return new UserResource($user);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully'
        ], 200);
    }
}
