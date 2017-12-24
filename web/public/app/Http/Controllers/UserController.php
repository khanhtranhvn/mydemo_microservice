<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function register(Request $request)
    {
//        $this->validate($request, [
//            'reg_email' => 'required',
//            'reg_password' => 'required',
//            'reg_password_confirm' => 'required'
//        ]);

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, '127.0.0.1:8081/register');
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, ['email' =>  'khanh.tranvn90@gmail.com','password'=>'123123']);
//        $html = curl_exec($ch);
//        echo $html;
//        var_dump($html);
//exit;
//        $client = new \GuzzleHttp\Client();
        $client = new \GuzzleHttp\Client();
//        $response = $client->request('POST', 'register');
//        $response = $client->get('127.0.0.1:8081/register');
        $response = $client->post('http://127.0.0.1:8081/login', ['email' =>  'khanh.tranvn90@gmail.com','password'=>'123123']);
        echo $response->getStatusCode(); // 200
        echo $response->getBody(); // { "type": "User", ....

    }
}
