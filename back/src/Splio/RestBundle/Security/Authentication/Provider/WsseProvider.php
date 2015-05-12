<?php

namespace Splio\RestBundle\Security\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Splio\RestBundle\Security\Authentication\Token\WsseUserToken;

/**
 *
 */
class WsseProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    /**
     *
     */
    public function __construct(UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;

        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, true);
        }
    }

    /**
     *
     */
    public function authenticate(TokenInterface $token)
    {
        $user = $this->userProvider->loadUserByUserName($token->getUsername());

        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getSecretKey())) {
            $authenticatedToken = new WsseUserToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new AuthenticationException('The WSSE authentication failed.');
    }

    /**
     *
     */
    protected function validateDigest($digest, $nonce, $created, $secret)
    {
        // Expire after 5 minutes
        if (time() - strtotime($created) > 300) {
            return false;
        }

        // Check nonce is unique in last 5 minutes
        if (file_exists($this->cacheDir.'/'.$nonce) && file_get_contents($this->cacheDir.'/'.$nonce) + 300 > time()) {
            throw new NonceExpiredException('Previously used nonce detected');
        }
        file_put_contents($this->cacheDir.'/'.$nonce, time());

        // Valid secret
        $expected = base64_encode(sha1($nonce.$created.$secret, true));

        return $digest === $expected;
    }

    /**
     *
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof WsseUserToken;
    }
}
