<?php

namespace Splio\WatchBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Splio\WatchBundle\Entity\User;

class UserTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $doctrine = $container->get('doctrine');
        $userRepository = $doctrine->getRepository('SplioWatchBundle:User');

        $julio = new User();
        $julio->setNickname('Julio');
        $claire = new User();
        $claire->setNickname('Claire');

        $claire->addFollower($julio);
        $claire->addFollower($claire);

        $em = $doctrine->getManager();
        $em->persist($julio);
        $em->persist($claire);
        $em->flush();
    }
}
