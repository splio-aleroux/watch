<?php

namespace Splio\RestBundle\Serializer;

use Splio\WatchBundle\Entity\EntityInterface;
use \Serializable;

interface SerializerInterface
{
	public function serialize(Serializable $object);
	public function supports(Serializable $object);
}