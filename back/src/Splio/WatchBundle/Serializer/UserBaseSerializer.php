<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\User;
use \Serializable;

class UserBaseSerializer implements SerializerInterface
{
	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();

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
}