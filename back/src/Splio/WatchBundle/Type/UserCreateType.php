<?php

namespace Splio\WatchBundle\Type;

use Symfony\Component\Validator\Constraints as Assert;

class UserCreateType
{
    public function bind($values = [])
    {
        foreach ($values as $key => $value) {
            if (property_exists(self::CLASS, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;
}
