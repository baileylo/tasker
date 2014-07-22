<?php namespace Task\Controller;

use Controller, GuzzleHttp;
use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;
use Task\Model\User;

class Auth extends Controller
{
    protected $request;
    protected $config;

    public function __construct(Request $request, Config $config, UserRepository $userRepo)
    {
        $this->request = $request;
        $this->config = $config;
    }

    public function login()
    {
        $response = GuzzleHttp\post('https://verifier.login.persona.org/verify', [
            'body'    => [
                'assertion' => $this->request->input('assertion'),
                'audience' => $this->config->get('app.url')
            ]
        ]);

        if ($response['status'] === 'okay') {

        }

        return $response->json();
    }

    public function logout()
    {

    }
} 