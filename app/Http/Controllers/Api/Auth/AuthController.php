<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\UserProfile;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{

    public function login(Request $request)
    {
        $rules = $this->rules();
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        if(Auth::attempt($request->only(['email','password']))){
            $user   = User::whereId(Auth::id())->with('profile')->first();
            $success['user'] =  $user;
            $success['api_token'] =  $user->createToken('metric')-> accessToken; 
            return $this->sendResponse($success, 'User login successfully.');
            // return response()->json(['user' => $user, 'api_token' => $accessToken]);
        }
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'         => 'required|email|unique:users',
            'password'      => 'required|min:6',
            'first_name'    => 'required',
            'last_name'     => 'required',
            'address'       => 'required|max:255'
        ]);
        
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $user = User::create([
            'email' =>$request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->profile()->create([
                'first_name' =>  $request->first_name,
                'last_name' =>  $request->last_name,
                'address' =>  $request->address,
            ]);

        $user   = User::whereId(Auth::id())->with('profile')->first();
        $success['user'] =  $user;
        $success['api_token'] =  $user->createToken('metric')-> accessToken; 
        return $this->sendResponse($success, 'User login successfully.');

    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
       // return response()->json(['message' => 'Successfully logged out']);
        $success['user'] =  "";

        return $this->sendResponse($success, 'Successfully logged out');
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required',
        ];
    }
}
