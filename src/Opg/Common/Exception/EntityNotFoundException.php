<?php


namespace Opg\Common\Exception;


class EntityNotFoundException extends OPGBaseException
{
    public function __construct($entity, $identifier, $code, $attribute)
    {
        parent::__construct(
            sprintf("Unable to load %s with identifier: %d", $entity, $identifier),
            self::CODE_DATA_NOT_FOUND,
            $attribute,
            'notFoundInDataLayer'
        );
    }
}
