<?php

namespace Splio\WatchBundle\Serializer;

use Splio\RestBundle\Serializer\SerializerInterface;
use Splio\WatchBundle\Entity\Tag;
use Splio\WatchBundle\Serializer\LinkSerializer;
use Splio\WatchBundle\Serializer\TagBaseSerializer;
use \Serializable;

class TagSerializer extends TagBaseSerializer implements SerializerInterface
{
	/**
     * @var LinkSerializer
     */
	protected $linkSerializer;

	public function serialize(Serializable $resource)
	{
		$serializer = parent::serialize($resource);
		$serialized['links'] = [];
		$links = $resource->getLinks();

		foreach ($links as $link) {
			$serialized['link'][] = $this->linkSerializer->serialize($link);
		}

		return $serialized;
	}

	public function setLinkSerializer(LinkBaseSerializer $linkSerializer)
	{
		$this->linkSerializer = $linkSerializer;
	}
}