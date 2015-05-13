<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Tag;
use Splio\WatchBundle\Serializer\LinkSerializer;
use \Serializable;

class TagBaseSerializer implements SerializerInterface
{
	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();

		return $serialized;
	}

	public function supports(Serializable $resource)
	{
		if (false === ($resource instanceof Tag)) {
            throw new \InvalidArgumentException(sprintf(
                '%s Serializer supports only instance of Splio\WatchBundle\Entity\Tag, %s given',
                __CLASS__,
                get_class($resource)
            ));
        }
	}
}