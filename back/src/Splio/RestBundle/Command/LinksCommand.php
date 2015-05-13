<?php

namespace Splio\RestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Splio\WatchBundle\Entity\Link;

class LinksCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('rest:linkCreate')
            ->setDescription('Create link')
            ->addArgument(
                'url',
                InputArgument::REQUIRED,
                'Url of link?'
            )
            ->addArgument(
                'userId',
                InputArgument::REQUIRED,
                'User id?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $userId = $input->getArgument('userId');
        $userRepository = new \Splio\WatchBundle\Entity\UserRepository();
        $em = $this->getContainer()->get('doctrine')->getManager();

        $user = $userRepository->findById($userId);

        $link = new Link();
        $link->setUrl($url);
        $link->setUser($user);
        $em->persist($link);
        $em->flush();

        $output->writeln($link->getId());
    }
}
