<?php namespace Task\Controller;

use Controller, GuzzleHttp, Redirect, Session;
use Illuminate\Http\Request;
use Illuminate\Config\Repository as Config;
use Task\Model\User;
use Task\Model\User\RepositoryInterface as UserRepo;

class Auth extends Controller
{
    protected $request;
    protected $config;

    /** @var \Task\Model\User\RepositoryInterface  */
    protected $userRepository;

    public function __construct(Request $request, Config $config, UserRepo $userRepo)
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

            $path = Session::pull('url.intended', route('home'));

            return [
                'status' => 'logged_in',
                'redirect_url' => url($path)
            ];
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