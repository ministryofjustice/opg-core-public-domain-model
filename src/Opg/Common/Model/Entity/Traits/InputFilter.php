<?php
namespace Opg\Common\Model\Entity\Traits;

use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Exception\UnusedException;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;

/**
 * Class InputFilter
 *
 * @package Opg\Common\Model\Entity\Traits
 */
trait InputFilter
{

    /**
     * @var InputFilter|InputFilterInterface
     * @Exclude
     */
    protected $inputFilter;

    /**
     * @Type("array")
     * @var array
     * @ReadOnly
     */
    protected $errorMessages = array();

    /**
     * @param InputFilterInterface $inputFilter
     *
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new UnusedException();
    }

    /**
     * Is the Entity valid
     *
     * If no validator keys are passed, all will be used
     * Optionally, a partial validation is done
     *
     * Usage
     * 1. $entity->isValid() // all validators are validated
     * 2. $entity->isValid(array('firstname')) // only 'firstname' is validated
     *
     * @param array $validations
     *
     * @return bool
     */
    public function isValid(array $validations = null)
    {
        $inputFilter = $this->getInputFilter()
            ->setData($this);

        if (!is_null($validations) && is_array($validations)) {
            $inputFilter->setValidationGroup($validations);
        }

        $isValid = $inputFilter->isValid();

        $this->errorMessages = $this->getInputFilter()->getMessages();

        return $isValid;
    }

    /**
     * @return array
     */
    public function getErrorMessages()
    {
        return array('errors' => $this->errorMessages);
    }

    /**
     * @param string $property     Name of the object property which the error is being logged against. Must exist in $this.
     * @param string $errorName    The type of error being logged e.g. InvalidFormatError.
     * @param string $errorMessage The error message body.
     *
     * @return object $this
     * @throws \InvalidArgumentException
     */
    public function addExternalError($property, $errorName, $errorMessage)
    {
        $fullClassName = get_class($this);

        if (!property_exists($fullClassName, $property)) {
            throw new \InvalidArgumentException('Invalid Property: ' . $property . ' does not exist in class ' . $fullClassName);
        }

        $errorArray = [$property => [$errorName => $errorMessage]];

        $this->errorMessages = array_merge_recursive($this->errorMessages, $errorArray);

        return $this;
    }
}
