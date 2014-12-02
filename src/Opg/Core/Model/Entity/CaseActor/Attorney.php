<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Opg\Common\Model\Entity\Traits\ToArray;

use Doctrine\ORM\Mapping as ORM;

use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use Zend\InputFilter\InputFilterInterface;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\GenericAccessor;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Attorney extends AttorneyAbstract
{
    use ToArray;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="lpa002SignatureDate")
     * @Groups("api-person-get")
     */
    protected $lpa002SignatureDate;

    /**
     * @ORM\Column(type = "integer", nullable = true)
     * @var int
     * @Type("boolean")
     * @Accessor(getter="getIsAttorneyApplyingToRegister", setter="setIsAttorneyApplyingToRegister")
     * @Groups("api-person-get")
     */
    protected $isAttorneyApplyingToRegister = self::OPTION_NOT_SET;

    /**
     * @return void|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'cases',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                        //@Todo figure out why the default is_empty message is displaying
                                        Callback::INVALID_VALUE    => 'This person needs an attached case',
                                        Callback::INVALID_CALLBACK => "An error occurred in the validation"
                                    ),
                                    // @codeCoverageIgnoreStart
                                    'callback' => function () {
                                            return $this->hasAttachedCase();
                                        }
                                    // @codeCoverageIgnoreEnd
                                )
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param \DateTime $lpa002SignatureDate
     *
     * @return Attorney
     */
    public function setLpa002SignatureDate(\DateTime $lpa002SignatureDate = null)
    {
        $this->lpa002SignatureDate = $lpa002SignatureDate;

        return $this;
    }

    /**
     * @return \DateTime $lpa002SignatureDate
     */
    public function getLpa002SignatureDate()
    {
        return $this->lpa002SignatureDate;
    }

    /**
     * @param bool $isAttorneyApplyingToRegister
     *
     * @return Attorney
     */
    public function setIsAttorneyApplyingToRegister($isAttorneyApplyingToRegister = null)
    {
        if ($isAttorneyApplyingToRegister === true) {
            $this->isAttorneyApplyingToRegister = self::OPTION_TRUE;
        } elseif ($isAttorneyApplyingToRegister === false) {
            $this->isAttorneyApplyingToRegister = self::OPTION_FALSE;
        } else {
            $this->isAttorneyApplyingToRegister = self::OPTION_NOT_SET;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsAttorneyApplyingToRegister()
    {
        switch ($this->isAttorneyApplyingToRegister) {
            case self::OPTION_TRUE:
                return (bool)true;
                break;
            default:
                return (bool)false;
        }
    }
}
