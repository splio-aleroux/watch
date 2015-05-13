<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Tag;
use Splio\WatchBundle\Serializer\LinkSerializer;
use Symfony\Component\Routing\RouterInterface;
use \Serializable;

class TagBaseSerializer implements SerializerInterface
{
	protected $router;

	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();

		$serialized['_links'] = [
			"self" => [
				"href" => $this->router->generate('watch_tag', ['id' => $resource->getId()], true),
				"version" => 1
			]
		];

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

	public function setRouter(RouterInterface $router)
	{
		$this->router = $router;
	}
}