<?php

namespace App\Controller;

use App\Model\User;

class HomeController
{
    public function index()
    {
        global $request;

        $data = [
            'name' => 'ali1',
            'email' => 'ali1122@ali32212.com',
            'password' => '1232131fdwf45689'
        ];

        $user = (new User())->find(5)->change($data);

        var_dump($user);

//        view('index');
    }
}