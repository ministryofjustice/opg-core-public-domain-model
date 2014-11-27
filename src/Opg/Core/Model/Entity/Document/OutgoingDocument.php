<?php

namespace Opg\Core\Model\Entity\Document;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Document
 */
class OutgoingDocument extends Document
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $systemType;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
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
     * @param string $systemType
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

}
