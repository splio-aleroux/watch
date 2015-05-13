<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Link;
use \Serializable;

class LinkSerializer implements SerializerInterface
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
		if (false === ($resource instanceof Link)) {
            throw new \InvalidArgumentException(sprintf(
                '%s Serializer supports only instance of Splio\WatchBundle\Entity\Link, %s given',
                __CLASS__,
                get_class($resource)
            ));
        }
	}
}