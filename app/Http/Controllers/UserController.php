<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ResponseTrait;
    public function login(UserLoginRequest $request)
    {
        $password = $request->password;
        $email = $request->email;

        $user = User::query()->where('email', '=', $email)->first();



        if (Hash::check($password, $user->password)) {
            return $this->success([
                'name' => $user->name,
                'id' => $user->id,
            ], trans('auth.succeed'));
        }
        return $this->failure([], trans('auth.password'));
    }
    public function register(UserRegisterRequest $request)
    {
        $password = Hash::make($request->password);
        $arr = $request->validated();
        $arr['password'] = $password;

        $user = User::create($arr);
        return $this->success([
            'name' => $user->name,
            'id' => $user->id,
        ], trans('auth.register'));
    }
}
