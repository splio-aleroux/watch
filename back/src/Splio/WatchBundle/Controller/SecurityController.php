<?php
namespace Splio\WatchBundle\Controller;

use Splio\WatchBundle\Service\UserService;
use Splio\RestBundle\Controller\BaseController as RestController;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client;
use Doctrine\Orm\EntityRepository;

/**
 * @Route("/", service="splio_watch.security_controller")
 */
class SecurityController extends RestController
{
    private $client_id = 'de3f0e26bf80de6384cd';
    private $client_secret = 'd751461f6f5779fc843a72a30a85f71239c59448';

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @Route("/auth/login", name="app_login")
     */
    public function loginAction()
    {
        $csrfToken = sha1('salty'.rand(0, time()));

        $endpoint = 'https://github.com/login/oauth/authorize';

        $url = $endpoint.'?'.http_build_query([
            'client_id' => $this->client_id,
            'state' => $csrfToken,
        ]);

        return new RedirectResponse($url);
    }

    /**
     * @Route("/auth/oauth", name="app_oauth")
     */
    public function oauthAction(Request $request)
    {

        // @TODO REFACTOR THIS MESS
        $code = $request->query->get('code');

        $client = new Client();

        $options = [
            "headers" => [
                "accept" => "application/json"
            ],
            'body' => [
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
                'code' => $code
            ]
        ];

        $response = $client->post('https://github.com/login/oauth/access_token', $options);
        $tokenData = $response->json();

        $accessToken = $tokenData['access_token'];
        $userResponse = $client->get('https://api.github.com/user', [
            'headers' => [
                'Authorization' => 'token '.$accessToken
            ]
        ]);

        $userData = $userResponse->json();
        if (!($user = $this->userRepository->findOneBy(['email' => $userData['email']]))) {
            var_dump($userData);
            die;
            $userPayload = [
                'email' => $userData['email'],
                'publicKey' => substr(sha1(rand(0, time()).microtime(true)), -12, 12),
                'secretKey' => hash('sha512', rand(0, time()).microtime(true)),
            ];

            $user = $this->userService->create($userPayload);
        }

        return new RedirectResponse('http://box.local/index.html?'.http_build_query(['public' => $user->getPublicKey(), 'secret' => $user->getSecretKey()]));
    }

    public function setUserService(UserService $service)
    {
        $this->userService = $service;
    }

    public function setUserRepository(EntityRepository $repository)
    {
        $this->userRepository = $repository;
    }
}