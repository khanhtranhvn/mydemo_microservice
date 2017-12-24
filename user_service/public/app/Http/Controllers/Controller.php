<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function jsonData($data, $flag = 1, $header_status = 200, $message = null)
    {
        /*
         * flag = 1: success
         * flag = 2: fail
         * flag = 3...
         */
        $arr = [
            'flag'      => $flag,
            'message'   => $message,
            'data'      => $data
        ];

        return response()->json($arr, $header_status);
    }
}
