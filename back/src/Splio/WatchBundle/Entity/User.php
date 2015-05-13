<?php

namespace Splio\WatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="email_idx", columns={"email"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="Splio\WatchBundle\Entity\UserRepository")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="encrypted_password", type="string", nullable=true)
     */
    private $encryptedPassword;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="connected_at", type="datetime", nullable=true)
     */
    private $connectedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="public_key", type="string", nullable=true)
     */
    private $publicKey;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_key", type="string", nullable=true)
     */
    private $secretKey;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Link", mappedBy="user", cascade={"persist"})
     */
    protected $links;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", inversedBy="followings")
     */
    private $followers;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="followers")
     */
    private $followings;

    /**
     * @see \Serializable::serialize
     */
    public function serialize()
    {
        return [
            'id' => $this->getId(),
            'email' => $this->getEmail(),
            'createAt' => $this->getCreatedAt()->format(\DateTime::W3C),
            'connectedAt' => $this->getConnectedAt(),
            'publicKey' => $this->getPublicKey()
        ];
    }

    /**
     * @see \Serializable::unserialize
     */
    public function unserialize($serialized)
    {
        throw new \LogicException(sprintf(
            'Unserialization of %s is not supported',
            self::CLASS
        ));
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->followers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followings = new \Doctrine\Common\Collections\ArrayCollection();
        $this->links = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getPassword()
    {
        return $this->getEncryptedPassword();
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getSalt()
    {
        return 'no-salt';
    }

    public function getUsername()
    {
        return $this->getEmail();
    }

    public function eraseCredentials()
    {
        return;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Add followers
     *
     * @param  \Splio\WatchBundle\Entity\User $followers
     * @return User
     */
    public function addFollower(\Splio\WatchBundle\Entity\User $followers)
    {
        $this->followers[] = $followers;

        return $this;
    }

    /**
     * Remove followers
     *
     * @param \Splio\WatchBundle\Entity\User $followers
     */
    public function removeFollower(\Splio\WatchBundle\Entity\User $followers)
    {
        $this->followers->removeElement($followers);
    }

    /**
     * Get followers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowers()
    {
        return $this->followers;
    }

    /**
     * Add followings
     *
     * @param  \Splio\WatchBundle\Entity\User $followings
     * @return User
     */
    public function addFollowing(\Splio\WatchBundle\Entity\User $followings)
    {
        $this->followings[] = $followings;

        return $this;
    }

    /**
     * Remove followings
     *
     * @param \Splio\WatchBundle\Entity\User $followings
     */
    public function removeFollowing(\Splio\WatchBundle\Entity\User $followings)
    {
        $this->followings->removeElement($followings);
    }

    /**
     * Get followings
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFollowings()
    {
        return $this->followings;
    }

    /**
     * Set email
     *
     * @param  string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set encryptedPassword
     *
     * @param  string $encryptedPassword
     * @return User
     */
    public function setEncryptedPassword($encryptedPassword)
    {
        $this->encryptedPassword = $encryptedPassword;

        return $this;
    }

    /**
     * Get encryptedPassword
     *
     * @return string
     */
    public function getEncryptedPassword()
    {
        return $this->encryptedPassword;
    }

    /**
     * Set createdAt
     *
     * @param  \dateTime $createdAt
     * @return User
     */
    public function setCreatedAt(\dateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \dateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set connectedAt
     *
     * @param  \dateTime $connectedAt
     * @return User
     */
    public function setConnectedAt(\dateTime $connectedAt)
    {
        $this->connectedAt = $connectedAt;

        return $this;
    }

    /**
     * Get connectedAt
     *
     * @return \dateTime
     */
    public function getConnectedAt()
    {
        return $this->connectedAt;
    }

    /**
     * Set publicKey
     *
     * @param  string $publicKey
     * @return User
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Get publicKey
     *
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set secretKey
     *
     * @param  string $secretKey
     * @return User
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * Get secretKey
     *
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * Add links
     *
     * @param  \Splio\WatchBundle\Entity\Link $links
     * @return User
     */
    public function addLink(\Splio\WatchBundle\Entity\Link $links)
    {
        $this->links[] = $links;

        return $this;
    }

    /**
     * Remove links
     *
     * @param \Splio\WatchBundle\Entity\Link $links
     */
    public function removeLink(\Splio\WatchBundle\Entity\Link $links)
    {
        $this->links->removeElement($links);
    }

    /**
     * Get links
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
    }
}
