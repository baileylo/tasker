<?php namespace Task\Controller;

use Controller, View, Auth;

class Home extends Controller
{

    public function home()
    {
        return View::make('home.index');
    }

    public function logIn()
    {
        return View::make('home.login');
    }
} 