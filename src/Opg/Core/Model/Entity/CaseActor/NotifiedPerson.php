<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 *
 */
class NotifiedPerson extends BasePerson implements PartyInterface, HasRelationshipToDonor, HasDateTimeAccessor
{
    use ToArray;
    use RelationshipToDonor;
    use DateTimeAccessor;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="notifiedDate")
     * @Groups("api-person-get")
     */
    protected $notifiedDate;

    /**
     * @param \DateTime $notifiedDate
     *
     * @return Lpa
     */
    public function setNotifiedDate(\DateTime $notifiedDate = null)
    {
        if (is_null($notifiedDate)) {
            $notifiedDate = new \DateTime();
        }
        $this->notifiedDate = $notifiedDate;

        return $this;
    }

    /**
     * @return \DateTime $notifiedDate
     */
    public function getNotifiedDate()
    {
        return $this->notifiedDate;
    }

    /**
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'powerOfAttorneys',
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
}
