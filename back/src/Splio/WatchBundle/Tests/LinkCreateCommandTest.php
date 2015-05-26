<?php

namespace Splio\WatchBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Command;

class LinkCreateCommandTest extends WebTestCase
{
    public function testCommand()
    {
        $client = static::createClient();
        $container = $client->getContainer();
        $commandBus = $container->get('command_bus');
        $linkService = $container->get('link_service');
        $userRepository = $container->get('user_repository');

        $user = new User();
        $user->setCreatedAt(new \DateTime());
        $user->setEmail(time().'@domain.tld');
        $userRepository->save($user);

        $command = new Command\LinkCreateCommand();
        $command->url = 'http://google.com';
        $command->user = $user;
        $command->tags = ['search','service','google'];

        $commandBus->handle($command);

        $link = $command->getLink();
        $nbTags = $linkService->countTags($link);

        $this->assertEquals(3, $nbTags);
    }
}
