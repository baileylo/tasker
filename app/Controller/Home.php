<?php namespace Task\Controller;

use Controller, View, Auth;

class Home extends Controller
{

    public function index()
    {
        return View::make('hello');
    }
} 