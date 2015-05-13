<?php

namespace Splio\WatchBundle\Command;

use Splio\WatchBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use SimpleBus\Message\Name\NamedMessage;

class UserCreateCommand implements NamedMessage
{
    /**
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    public $email;

    /**
     * @var User
     */
    protected $user;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function setUser(User $user)
    {
        if (!$this->user) {
            $this->user = $user;
        }
    }

    public function getUser()
    {
        return $this->user;
    }

    public static function messageName()
    {
        return 'splio_watch_create_user';
    }
}
