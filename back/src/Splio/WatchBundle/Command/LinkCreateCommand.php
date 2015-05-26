<?php

namespace Splio\WatchBundle\Command;

use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use SimpleBus\Message\Name\NamedMessage;

class LinkCreateCommand implements NamedMessage
{
    /**
     * @Assert\NotBlank()
     */
    public $url;

    /**
     * @Assert\NotBlank()
     */
    public $user;

    /**
     * @var Link
     */
    protected $link;

    public function setLink(Link $link)
    {
        if (!$this->link) {
            $this->link = $link;
        }
    }

    public function getLink()
    {
        return $this->link;
    }

    public static function messageName()
    {
        return 'splio_watch_create_link';
    }
}
