<?php

namespace Splio\WatchBundle\Command;

use Splio\WatchBundle\Entity\Tag;
use Symfony\Component\Validator\Constraints as Assert;
use SimpleBus\Message\Name\NamedMessage;

class TagCreateCommand implements NamedMessage
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @var Tag
     */
    protected $tag;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setTag(Tag $tag)
    {
        if (!$this->tag) {
            $this->tag = $tag;
        }
    }

    public function getTag()
    {
        return $this->tag;
    }

    public static function messageName()
    {
        return 'splio_watch_create_tag';
    }
}
