<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Serializer\TagBaseSerializer;
use Splio\WatchBundle\Serializer\UserBaseSerializer;
use \Serializable;

class LinkBaseSerializer implements SerializerInterface
{
	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();

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
}
