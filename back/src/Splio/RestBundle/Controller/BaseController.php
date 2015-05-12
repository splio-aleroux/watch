<?php

namespace Splio\RestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class BaseController
{
    /**
     * @var RouterInterface
     */
    protected $router = null;

    /**
     * @var boolean
     */
    protected $isDebug;

    public function indexAction()
    {
        return $this->renderJson(["foo" => "bar"], 201);
    }

    protected function renderJson($content, $statusCode = 200, $headers = [])
    {
        // Encode in JSON
        if (!is_string($content)) {
            if ($this->isDebug) {
                $content = json_encode($content, JSON_PRETTY_PRINT);
            } else {
                $content = json_encode($content);
            }

            // Manage JSON Error
        }

        $headers = array_merge(['content-type' => 'application/json'], $headers);
        return new Response($content, $statusCode, $headers);
    }

    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function setDebug($debug = true)
    {
        $this->isDebug = $debug;
    }
}
