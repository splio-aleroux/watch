<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\User;
use Splio\WatchBundle\Serializer\UserBaseSerializer;
use \Serializable;

class UserSerializer extends UserBaseSerializer implements SerializerInterface
{
	/**
     * @var LinkSerializer
     */
	protected $linkSerializer;

	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();
		$serialized['links'] = [];
		$links = $resource->getLinks();

		foreach ($links as $link) {
			$serialized['links'][] = $this->linkSerializer->serialize($link);
		}

		return $serialized;
	}

	public function supports(Serializable $resource)
	{
		if (false === ($resource instanceof User)) {
            throw new \InvalidArgumentException(sprintf(
                '%s Serializer supports only instance of Splio\WatchBundle\Entity\User, %s given',
                __CLASS__,
                get_class($resource)
            ));
        }
	}

	public function setLinkSerializer(\Splio\WatchBundle\Serializer\LinkBaseSerializer $serializer)
	{
		$this->linkSerializer = $serializer;
	}
}