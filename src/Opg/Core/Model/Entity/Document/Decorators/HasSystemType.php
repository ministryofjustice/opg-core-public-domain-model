<?php

namespace Opg\Core\Model\Entity\Document\Decorators;

interface HasSystemType
{
    /**
     * @param string $systemType
     * @return HasSystemType
     */
    public function setSystemType($systemType);

    /**
     * @return string
     */
    public function getSystemType();
}
