<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\User;
use Symfony\Component\Routing\RouterInterface;
use \Serializable;

class UserBaseSerializer implements SerializerInterface
{
	protected $router;

	public function serialize(Serializable $resource)
	{
		$this->supports($resource);
		$serialized = $resource->serialize();

		$serialized['_links'] = [
			"self" => [
				"href" => $this->router->generate('splio_watch_user', ['id' => $resource->getId()], true),
				"version" => 1
			]
		];

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

	public function setRouter(RouterInterface $router)
	{
		$this->router = $router;
	}
}