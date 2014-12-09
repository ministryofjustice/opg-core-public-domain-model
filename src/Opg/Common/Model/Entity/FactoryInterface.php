<?php

namespace Opg\Common\Model\Entity;

use JMS\Serializer\Serializer;
use Opg\Core\Model\Entity\LegalEntity\LegalEntity;

/**
 * Interface FactoryInterface
 * @package Opg\Common\Model\Entity
 */
interface FactoryInterface
{
    /**
     * @param array      $data
     * @param Serializer $serializer
     * @return LegalEntity
     * @throws \Exception
     */
    public static function create(array $data, Serializer $serializer);
}
