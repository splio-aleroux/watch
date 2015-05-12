<?php

namespace Splio\RestBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 *
 */
class WsseUserToken extends AbstractToken
{
    public $created;
    public $digest;
    public $nonce;

    /**
     *
     */
    public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        // Arrived here, user is authenticated
        $this->setAuthenticated(true);
    }

    public function getCredentials()
    {
        return '';
    }
}
