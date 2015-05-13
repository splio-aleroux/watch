<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Tag;
use \Serializable;

class TagSerializer implements SerializerInterface
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
		if (false === ($resource instanceof Tag)) {
            throw new \InvalidArgumentException(sprintf(
                '%s Serializer supports only instance of Splio\WatchBundle\Entity\Tag, %s given',
                __CLASS__,
                get_class($resource)
            ));
        }
	}
}