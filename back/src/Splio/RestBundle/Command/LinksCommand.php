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
            ->addArgument(
                'tagId',
                InputArgument::REQUIRED,
                'Tag id?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = $input->getArgument('url');
        $userId = $input->getArgument('userId');
        $tagId = $input->getArgument('tagId');
        $userRepository = $this->getContainer()->get('user_repository');
        $tagRepository = $this->getContainer()->get('tag_repository');
        $em = $this->getContainer()->get('doctrine')->getManager();

        $user = $userRepository->find($userId);
        $tag = $tagRepository->find($tagId);

        $link = new Link();
        $link->setCreatedAt(new \DateTime());
        $link->setUrl($url);
        $link->setUser($user);
        $link->addTag($tag);
        $em->persist($link);
        $em->flush();

        $output->writeln($link->getId());
    }
}
