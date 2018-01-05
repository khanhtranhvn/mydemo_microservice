<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    public function register(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'http://192.168.99.100:8081/login',
            [
                'form_params' => [
                    'email' =>  'khanh.tranvn90@gmail.com',
                    'password'=>'123213'
                ]
            ]
        );
        echo $response->getStatusCode();
        echo $response->getBody();

    }

    public function logout() {
        $client = new \GuzzleHttp\Client();
        $response = $client->post(
            'http://192.168.99.100:8081/logout'
        );
        if ( $response->getStatusCode() == 200 ) {
            $request = \Request();
            $request->session()->forget('api_token');
            $request->session()->flush();
            return redirect('/');
        }

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
            $request->session()->put('api_token', $responseArr['data']['api_token']);
            return redirect('/');
        } catch (\Exception $exception) {
            $responseException = $exception->getResponse()->getBody(true);
            return view('pages.login', [
                'responseException' => json_decode($responseException->getContents(),true)
            ] );
        }
    }

    public function getTodoList() {
        if ( \Request::session()->has('api_token') ) {
            $apiToken = \Request::session()->get('api_token');
            $client = new \GuzzleHttp\Client();
            $response = $client->get(
                'http://192.168.99.100:8081/getToDoList',
                [
                    'form_params' => [
                        'api_token' =>  $apiToken
                    ]
                ]
            );
            var_dump($response);exit;
        } else {
            return redirect('/login');
        }
    }
}
