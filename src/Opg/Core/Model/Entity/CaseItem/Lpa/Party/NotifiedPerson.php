<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 *
 */
class NotifiedPerson extends BasePerson implements PartyInterface, HasRelationshipToDonor
{
    use ToArray;
    use RelationshipToDonor;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getNotifiedDateString",setter="setNotifiedDateString")
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
     * @param string $notifiedDate
     *
     * @return Lpa
     */
    public function setNotifiedDateString($notifiedDate)
    {
        if (!empty($notifiedDate)) {
            $notifiedDate = OPGDateFormat::createDateTime($notifiedDate);

            if ($notifiedDate) {
                $this->setNotifiedDate($notifiedDate);
            }
        }

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
     * @return string
     */
    public function getNotifiedDateString()
    {
        if (!empty($this->notifiedDate)) {
            return $this->notifiedDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
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
