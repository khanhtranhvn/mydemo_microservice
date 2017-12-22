<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

use Illuminate\Http\Request;
use App\User;

$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

//class User extends \Illuminate\Database\Eloquent\Model {
//    protected $table = 'user_service';
//}

$app->get('user', function() {
    var_dump(User::all());exit;
});

$app->get('user/{id}', function($id) {
    return response()->json(User::find($id));
});

$app->post('user', function(Request $request) {
    $user = new User();
    $user->email = $request->input('email');

    $user->save();
    return response()->json($user, 201);
});

$app->delete('user/{id}', function($id) {
    Dev::find($id)->delete();
    return response('', 200);
});

$app->patch('user/{id}', function(Request $request, $id) {
    $user = User::find($id);
    $user->email = $request->input('email');

    $user->save();
    return response()->json($user);
});

$app->run($app['request']);
