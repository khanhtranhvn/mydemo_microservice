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
//        curl_setopt($ch, CURLOPT_URL, 'http://192.168.99.100:8081/register');
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
        $response = $client->post(
            'http://192.168.99.100:8081/login',
            [
                'form_params' => [
                    'email' =>  'khanh.tranvn90@gmail.com',
                    'password'=>'123213'
                ]
            ]
        );
        echo $response->getStatusCode(); // 200
        echo $response->getBody(); // { "type": "User", ....

    }

    public function logout() {
        $client = new \GuzzleHttp\Client();
//        $response = $client->request('POST', 'register');
//        $response = $client->get('127.0.0.1:8081/register');
        $response = $client->post(
            'http://192.168.99.100:8081/logout'
        );
        echo $response->getStatusCode(); // 200
        echo $response->getBody(); // { "type": "User", ....
    }

    public function logIn ( Request $request ) {

        $request->validate([
            'lg_username' => 'required',
            'lg_password' => 'required',
        ]);

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->post(
                'http://192.168.99.100:8081/login',
                [
                    'form_params' => [
                        'email' =>  $request->input('lg_username'),
                        'password'=>$request->input('lg_password')
                    ]
                ]
            );

            $responseBody =  $response->getBody();
            $responseArr = \GuzzleHttp\json_decode($responseBody->getContents(), true);
            var_dump($responseArr['api_token']); exit;
            $request->session()->put('api_token', $responseArr['api_token']);
            return redirect()->route('/');
        } catch (\Exception $exception) {
            var_dump($exception); exit;
            $responseException = $exception->getResponse()->getBody(true);
            return view('pages.login', [
                'responseException' => json_decode($responseException->getContents(),true)
            ] );
        }
    }
}
