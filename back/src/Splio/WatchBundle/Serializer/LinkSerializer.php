<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Serializer\TagSerializer;
use Splio\WatchBundle\Serializer\UserSerializer;
use \Serializable;

class LinkSerializer implements SerializerInterface
{
	/**
     * @var TagSerializer
     */
	protected $tagSerializer;

	/**
     * @var UserSerializer
     */
	protected $userSerializer;

	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();
		$serialized['user'] = $this->userSerializer->serialize($resource->getUser());
		$serialized['tags'] = [];
		$tags = $resource->getTags();

		foreach ($tags as $tag) {
			$serialized['tags'][] = $this->tagSerializer->serialize($tag);
		}

		return $serialized;
	}

	public function supports(Serializable $resource)
	{
		if (false === ($resource instanceof Link)) {
            throw new \InvalidArgumentException(sprintf(
                '%s Serializer supports only instance of Splio\WatchBundle\Entity\Link, %s given',
                __CLASS__,
                get_class($resource)
            ));
        }
	}

	public function setTagSerializer(TagSerializer $tagSerializer)
	{
		$this->tagSerializer = $tagSerializer;
	}

	public function setUserSerializer(UserSerializer $userSerializer)
	{
		$this->userSerializer = $userSerializer;
	}
}
