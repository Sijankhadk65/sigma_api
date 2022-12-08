<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    /**
     * Instantiate new UserController instance.
     * 
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Creates a new User
     * 
     * @return User $newUser
     */
    public function create(Request $request)
    {
        // echo "creates a new user";
        $param = $request->all()['param'];
        $param['password'] = Hash::make($param['password']);
        $newUser = User::create($param);

        return (new Response($newUser, 200))
            ->header('content-type', 'application/json');
    }

    /**
     * Authenticates the User
     * 
     * @param Request $request
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $responseCode = 200;
        $param = $request->all();
        $requestedUser = User::query()
            ->where('username', '=', $param['username'])
            ->first();
        if ($requestedUser != null) {
            if (Hash::check($param['password'], $requestedUser->password)) {
                $data =  response()->json($requestedUser);
            } else {
                $data =  response()->json([]);
                $responseCode = 401;
                $data->exception = "Invalid Password";
            }
        } else {
            $data = response()->json([]);
            $data->exception = "Invalid User";
            $responseCode = 402;
        }
        $response = [
            'data' => $data,
        ];
        return $response;
    }
}
