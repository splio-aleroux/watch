<?php

namespace Splio\WatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(
 *     name="user",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="nickname_idx", columns={"nickname"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="Splio\WatchBundle\Entity\UserRepository")
 */
class User
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
    private $nickname;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isSpecialUser = false;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstname;

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
     * Constructor
     */
    public function __construct()
    {
        $this->followers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->followings = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nickname
     *
     * @param string $nickname
     * @return User
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set isSpecialUser
     *
     * @param boolean $isSpecialUser
     * @return User
     */
    public function setIsSpecialUser($isSpecialUser)
    {
        $this->isSpecialUser = $isSpecialUser;

        return $this;
    }

    /**
     * Get isSpecialUser
     *
     * @return boolean
     */
    public function getIsSpecialUser()
    {
        return $this->isSpecialUser;
    }

    /**
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Add followers
     *
     * @param \Splio\WatchBundle\Entity\User $followers
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
     * @param \Splio\WatchBundle\Entity\User $followings
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
}
