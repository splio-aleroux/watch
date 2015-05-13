<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Link;
use Splio\WatchBundle\Serializer\LinkBaseSerializer;
use Splio\WatchBundle\Serializer\TagSerializer;
use Splio\WatchBundle\Serializer\UserSerializer;
use \Serializable;

class LinkSerializer extends LinkBaseSerializer implements SerializerInterface
{
	/**
     * @var TagSerializer
     */
	protected $tagSerializer;

	/**
     * @var UserSerializer
     */
	protected $userSerializer;

	public function serialize(Serializable $resource)
	{
		$serialized = parent::serialize($resource);
		$serialized['user'] = $this->userSerializer->serialize($resource->getUser());
		$serialized['tags'] = [];
		$tags = $resource->getTags();

		$serialized['tags'] = [
			"data" => [],
			"size" => count($tags),
			"_links" => []
		];

		foreach ($tags as $tag) {
			$serialized['tags']['data'][] = $this->tagSerializer->serialize($tag);
		}

		return $serialized;
	}

	public function setTagSerializer(TagBaseSerializer $tagSerializer)
	{
		$this->tagSerializer = $tagSerializer;
	}

	public function setUserSerializer(UserBaseSerializer $userSerializer)
	{
		$this->userSerializer = $userSerializer;
	}
}
