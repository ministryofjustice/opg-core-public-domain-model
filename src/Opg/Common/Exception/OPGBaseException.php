<?php


namespace Opg\Common\Exception;


abstract class OPGBaseException extends \Exception
{

    const CODE_DATA_NOT_FOUND = 404;

    const CODE_DATA_INVALID   = 400;

    /**
     * @var string
     */
    protected $attributeName;

    /**
     * @var string
     */
    protected $messageDescriptor;

    /**
     * @param string $message
     * @param int    $code
     * @param string $attribute
     * @param string $messageDescriptor
     */
    public function __construct($message, $code, $attribute, $messageDescriptor = 'unexpectedValue')
    {
        $this->messageDescriptor = $messageDescriptor;
        $this->attributeName = $attribute;
        parent::__construct($message, $code);
    }

    /**
     * @return string
     */
    public function getAttribute()
    {
        return $this->attributeName;
    }

    /**
     * @param $attribute
     * @return $this
     */
    public function setAttribute($attribute)
    {
        $this->attributeName = $attribute;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessageDescriptor()
    {
        return $this->messageDescriptor;
    }

    /**
     * @param $descriptor
     * @return $this
     */
    public function setMessageDescriptor($descriptor)
    {
        $this->messageDescriptor = $descriptor;

        return $this;
    }
}
