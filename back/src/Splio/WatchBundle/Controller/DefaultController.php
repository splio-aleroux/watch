<?php

namespace Splio\WatchBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Splio\WatchBundle\Service\UserService;

class DefaultController
{
    /**
     * @var UserService
     */
    protected $userService;

    public function indexAction($name)
    {
        return new Response('bonjour : le service est un  '. get_class($this->userService));
    }

    public function setUserService(UserService $service)
    {
        $this->userService = $service;
    }
}
