<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\User;
use \Serializable;

class UserSerializer implements SerializerInterface
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
			$serialized['link'][] = $this->linkSerializer->serialize($link);
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

	public function setLinkSerializer(\Splio\WatchBundle\Serializer\LinkSerializer $serializer)
	{
		$this->linkSerializer = $serializer;
	}
}