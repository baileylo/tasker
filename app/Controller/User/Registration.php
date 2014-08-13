<?php namespace Task\Controller\User;

use Controller, View, Redirect, Session, Input;
use Task\Model\User;
use Task\Service\Validator\User\Validator;

class Registration extends Controller
{

    public function __construct(Validator $userValidator)
    {
        $this->validator = $userValidator;
    }

    public function show()
    {
        return View::make('user.register', ['email' => Session::get('email')]);
    }

    public function handle()
    {
        $data = Input::only(['first_name', 'last_name', 'email']);

        if ($errors = $this->validator->getErrors($data)) {
            return Redirect::back()->withInput()->withErrors($errors);
        }

        $user = new User();
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->save();

        Session::forget('email');

        return Redirect::route('home')->with('notification', 'Thank you for registering!');
    }
} 