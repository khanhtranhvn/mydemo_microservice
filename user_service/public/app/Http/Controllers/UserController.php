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

        if (Hash::check($request->input('password'), $user->password)) {
            $user->generateToken();

            return $this->jsonData($user, 1, 200, 'Login successful!');
        }

        return $this->jsonData(null, 2, 401, 'The email or password is incorrect!');
    }

    public function logout()
    {
        $user = Auth::user();
        if (!empty($user)) {
            $user->api_token = null;
            $user->save();
        }

        return $this->jsonData(null, 1, 200, 'Logout successful');
    }
}