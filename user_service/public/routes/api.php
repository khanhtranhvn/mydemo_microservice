<?php
/**
 * Created by PhpStorm.
 * User: khanh
 * Date: 12/23/17
 * Time: 17:07
 */

use Illuminate\Http\Request;

$router->post('login', 'UserController@login');
$router->post('logout', 'UserController@logout');
$router->post('register', 'UserController@register');

$router->group(['middleware' => 'auth', 'prefix' => 'api/'], function() use ($router) {
    $router->get('user', function (Request $request) {
        return $request->user();
    });
});