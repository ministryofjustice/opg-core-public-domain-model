<?php

namespace Opg\Core\Model\Entity\Documents;

use Opg\Core\Model\Entity\Person\Person;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Correspondence
 */
class OutgoingDocument extends Document
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $systemType;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $recipientName;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $address;

    /**
     * @ORM\Column(type="integer")
     * @var int
     * @Accessor(getter="getDirection", setter="setDirection")
     */
    protected $direction = self::DOCUMENT_OUTGOING_CORRESPONDENCE;


    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'id',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'Digits'
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
     * @param string $recipientName
     *
     * @return OutgoingDocument
     */
    public function setRecipientName($recipientName)
    {
        $this->recipientName = $recipientName;

        return $this;
    }

    /**
     * @return string
     */
    public function getRecipientName()
    {
        return $this->recipientName;
    }

    /**
     * @param Person $person
     * @return OutgoingDocument
     * @deprecated use setCorrespondent
     */
    public function setPerson(Person $person)
    {
        $this->correspondent = $person;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\Person\Person
     * @deprecated use getCorrespondent
     */
    public function getPerson()
    {
        return $this->correspondent;
    }

    /**
     * @param $address
     * @return OutgoingDocument
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param $systemType
     * @return OutgoingDocument
     */
    public function setSystemType($systemType)
    {
        $this->systemType = $systemType;

        return $this;
    }

    /**
     * @return string
     */
    public function getSystemType()
    {
        return $this->systemType;
    }

    /**
     * @param string $createdDate
     *
     * @return OutgoingDocument
     */
    public function setCreatedDateString($createdDate)
    {
        if (!empty($createdDate)) {
            $createdDate = OPGDateFormat::createDateTime($createdDate);

            return $this->setCreatedDate($createdDate);
        }

        return $this->setCreatedDate(new \DateTime());
    }

}
