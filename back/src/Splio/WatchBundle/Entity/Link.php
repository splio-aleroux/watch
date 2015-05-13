<?php

namespace Splio\WatchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Link
 *
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="Splio\WatchBundle\Entity\LinkRepository")
 */
class Link implements \Serializable
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
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="links", cascade={"persist"})
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string")
     */
    private $url;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Tag", mappedBy="links")
     */
    protected $tags;

    /**
     * @see \Serializable::serialize
     */
    public function serialize()
    {
        return [
            'id' => $this->getId(),
            'createAt' => $this->getCreatedAt()->format(\DateTime::W3C),
            'url' => $this->getUrl()
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param  \Splio\WatchBundle\Entity\User $user
     * @return Link
     */
    public function setUser(\Splio\WatchBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Splio\WatchBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set url
     *
     * @param  string $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param  \Splio\WatchBundle\Entity\Tag $tags
     * @return Link
     */
    public function addTag(\Splio\WatchBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Splio\WatchBundle\Entity\Tag $tags
     */
    public function removeTag(\Splio\WatchBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set createdAt
     *
     * @param  \DateTime $createdAt
     * @return Link
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}
