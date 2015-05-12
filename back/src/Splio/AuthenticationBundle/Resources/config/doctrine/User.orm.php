<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->customRepositoryClassName = 'Splio\AuthenticationBundle\Entity\UserRepository';
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'type' => 'integer',
   'id' => true,
   'columnName' => 'id',
  ));
$metadata->mapField(array(
   'fieldName' => 'signedUpAt',
   'type' => 'string',
   'length' => '255',
   'columnName' => 'signedUpAt',
  ));
$metadata->mapField(array(
   'fieldName' => 'email',
   'type' => 'string',
   'length' => '255',
   'columnName' => 'email',
  ));
$metadata->mapField(array(
   'columnName' => 'encryptedPassword',
   'fieldName' => 'encryptedPassword',
   'type' => 'string',
   'length' => 255,
  ));
$metadata->mapField(array(
   'columnName' => 'roles',
   'fieldName' => 'roles',
   'type' => 'text',
  ));
$metadata->mapField(array(
   'columnName' => 'state',
   'fieldName' => 'state',
   'type' => 'string',
   'length' => 255,
  ));
$metadata->mapField(array(
   'columnName' => 'accessToken',
   'fieldName' => 'accessToken',
   'type' => 'string',
   'length' => 255,
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);