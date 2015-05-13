<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Serializer\TagBaseSerializer;
use Splio\WatchBundle\Serializer\UserBaseSerializer;
use Symfony\Component\Routing\RouterInterface;
use \Serializable;

class LinkBaseSerializer implements SerializerInterface
{
	protected $router;

	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();

		$serialized['_links'] = [
			"self" => [
				"href" => $this->router->generate('watch_link', ['id' => $resource->getId()], true),
				"version" => 1
			]
		];

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

	public function setRouter(RouterInterface $router)
	{
		$this->router = $router;
	}
}
