<?php

namespace Splio\AuthenticationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SplioAuthenticationBundle:Default:index.html.twig', array('name' => $name));
    }
}
