<?php

namespace Splio\WatchBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Splio\WatchBundle\Service\UserService;
use Splio\WatchBundle\Service\LinkService;

class DefaultController
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var LinkService
     */
    protected $linkService;

    public function indexAction($name)
    {
        return new Response('bonjour : le service est un  '. get_class($this->linkService));
    }

    public function setUserService(UserService $service)
    {
        $this->userService = $service;
    }

    public function setLinkService(LinkService $service)
    {
        $this->linkService = $service;
    }
}
