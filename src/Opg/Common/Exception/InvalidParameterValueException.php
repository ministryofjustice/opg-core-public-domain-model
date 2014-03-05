<?php


namespace Opg\Common\Exception;


class InvalidParameterValueException extends \Exception
{
    /**
     * @var string
     */
    protected $attributeName;

    /**
     * @param string     $entity
     * @param string     $identifier
     * @param int        $code
     * @param string     $attribute
     */
    public function __construct($entity, $identifier, $code, $attribute)
    {
        $this->attributeName = $attribute;
        parent::__construct( sprintf( "Unable to load %s with identifier: %d", $entity, $identifier ), $code);
    }

    /**
     * @return string
     */
    public function getAttribute()
    {
        return $this->attributeName;
    }
}
