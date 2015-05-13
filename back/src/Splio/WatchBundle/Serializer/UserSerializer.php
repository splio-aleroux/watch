<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\User;
use \Serializable;

class UserSerializer implements SerializerInterface
{
	public function serialize(Serializable $resource)
	{
		$this->supports($resource);

		$serialized = array_merge(
			$resource->serialize(),
			'_links' => [
				// Todo prepare links for relations
			]
		);

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