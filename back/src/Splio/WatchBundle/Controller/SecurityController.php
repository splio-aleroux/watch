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
    protected $frontAppUrl;
    protected $githubAppId;
    protected $githubAppSecret;

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
            'client_id' => $this->githubAppId,
            'state' => $csrfToken,
        ]);

        return new RedirectResponse($url);
    }

    /**
     * @Route("/auth/oauth", name="app_oauth")
     */
    public function oauthAction(Request $request)
    {

        // @TODO Refactor this mess
        // @TODO Check that state is the same as provided earlier
        // @TODO Split into dedicated methods
        $code = $request->query->get('code');
        $client = new Client();

        $options = [
            "headers" => [
                "accept" => "application/json"
            ],
            'body' => [
                'client_id' => $this->githubAppId,
                'client_secret' => $this->githubAppSecret,
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

        if (!array_key_exists('email', $userData)) {
            // OAuth failure
            return new RedirectResponse($this->router->generateUrl('app_login', [], true));
        }

        if (!($user = $this->userRepository->findOneBy(['email' => $userData['email']]))) {
            $userPayload = [
                'email' => $userData['email'],
                'publicKey' => substr(sha1(rand(0, time()).microtime(true)), -12, 12),
                'secretKey' => hash('sha512', rand(0, time()).microtime(true)),
            ];

            $user = $this->userService->create($userPayload);
        }

        return new RedirectResponse($this->frontAppUrl.'?'.http_build_query(['public' => $user->getPublicKey(), 'secret' => $user->getSecretKey()]));
    }

    public function setUserService(UserService $service)
    {
        $this->userService = $service;
    }

    public function setUserRepository(EntityRepository $repository)
    {
        $this->userRepository = $repository;
    }

    public function setFrontAppUrl($url)
    {
        $this->frontAppUrl = $url;
    }

    public function setGithubAppId($value)
    {
        $this->githubAppId = $value;
    }
    public function setGithubAppSecret($value)
    {
        $this->githubAppSecret = $value;
    }
}