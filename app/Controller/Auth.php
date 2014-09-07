<?php namespace Task\Controller;

use Controller, GuzzleHttp, Response, Session;
use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;
use Portico\Task\User\User;
use Portico\Task\User\UserRepository;

class Auth extends Controller
{
    /** @var Request  */
    protected $request;

    /** @var Config  */
    protected $config;

    /** @var UserRepository  */
    protected $userRepository;

    public function __construct(Request $request, Config $config, UserRepository $userRepo)
    {
        $this->request = $request;
        $this->config = $config;
        $this->userRepository = $userRepo;
    }

    public function login()
    {
        $response = GuzzleHttp\post('https://verifier.login.persona.org/verify', [
            'body'    => [
                'assertion' => $this->request->input('assertion'),
                'audience' => $this->config->get('app.url')
            ]
        ]);

        if ($response->json()['status'] === 'okay') {
            $user = $this->userRepository->findByEmail($response->json()['email']);
            if (!$user) {
                Session::set('email', $response->json()['email']);
                return [
                    'status' => 'new_account_required',
                    'redirect_url' => route('registration'),
                ];
            }

            \Auth::login($user);

            return Response::make([
                'status' => 'logged_in',
                'redirect_url' => url(Session::pull('url.intended', route('home')))
            ]);
        }

        return $response->json();
    }

    protected function createNewUserAccount(array $userData)
    {
        $user = new User();
        $user->email = $userData['email'];
        $user->first_name = 'Joe';
        $user->last_name = 'Public';
        $user->save();

        return $user;
    }

    public function logout()
    {
        \Auth::logout();

        return [
            'redirect_url' => route('home')
        ];
    }
} 