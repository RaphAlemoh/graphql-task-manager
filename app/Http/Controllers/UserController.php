<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use ApiResponser;

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $data['success'] = true;
            $success['token'] = $user->createToken('Aptiw')->accessToken;
            $success['name'] = $user->name;
            return $this->showOne($data, 200);
        }

        return $this->errorResponse('Unauthorised', 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $data['success'] = true;
        $data['token'] = $user->createToken('Aptiw')->accessToken;
        $data['name'] = $user->name;

        return $this->showOne($data, 200);
    }

    public function logout(Request $request)
    {
        try {

            $request->user()->token()->revoke();

            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return $this->showOne($response, 200);
    }
}
