<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 12/23/17
 * Time: 16:49
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ( empty($user) ) {
            return $this->jsonData(null, 2, 401, 'The email or password is incorrect!');
        }

        if (Hash::check($request->input('password'), $user->password)) {
            $user->generateToken();

            return $this->jsonData($user, 1, 200, 'Login successful!');
        }
        return $this->jsonData(null, 2, 401, 'The email or password is incorrect!');
    }

    public function logout(Request $request)
    {
//        $user = Auth::user();
        $user = User::where('api_token', $request->input('api_token'))->first();
        if (!empty($user)) {
            $user->api_token = null;
            $user->save();
        }

        return $this->jsonData(null, 1, 200, 'Logout successful');
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user) {
            return $this->jsonData($user, 1, 200, 'Email already exist!');
        } else {
            $user = new User();
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            return $this->jsonData($user, 1, 200, 'Register successful!');
        }

    }
}