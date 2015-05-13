<?php

namespace Splio\RestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Splio\WatchBundle\Entity\Tag;

class TagsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('rest:tagCreate')
            ->setDescription('Create tag')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of tag?'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $em = $this->getContainer()->get('doctrine')->getManager();

        $tag = new Tag();
        $tag->setName($name);
        $tag->setCreatedAt(new \DateTime());
        $em->persist($tag);
        $em->flush();

        $output->writeln($tag->getId());
    }
}
