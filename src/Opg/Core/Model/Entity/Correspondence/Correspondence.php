<?php
namespace Opg\Core\Model\Entity\Correspondence;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * @ORM\Table(name = "correspondence")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Correspondence
 */
class Correspondence extends BaseCorrespondence
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
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getCreatedDateString",setter="setCreatedDateString")
     */
    protected $createdDate;

    /**
     * Don't persist this
     * @var CaseItem $case
     */
    protected $case;

    /**
     * Non persistable entity, used for validation of create
     * @var Person person
     */
    protected $person;

    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }

    /**
     * Fulfil IteratorAggregate interface requirements
     *
     * @return \RecursiveArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }


    /**
     * @return InputFilter|InputFilterInterface
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
     * @param int $id
     *
     * @return Correspondence
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return Correspondence
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param string $recipientName
     *
     * @return Correspondence
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
     * @param \Opg\Core\Model\Entity\CaseItem\CaseItem $case
     */
    public function setCase($case)
    {
        $this->case = $case;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\CaseItem
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @param \Opg\Core\Model\Entity\Person\Person $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }

    /**
     * @return \Opg\Core\Model\Entity\Person\Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    public function getDocumentStoreFilename()
    {
        return $this->getId() . "_" . $this->getFilename();
    }

    /**
     * @param string $type
     *
     * @return Correspondence
     */
    public function setType($type)
    {
        $this->type = (string)$type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $address
     * @return $this
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
     * @return $this
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
     * @param \DateTime $createdDate
     *
     * @return $this
     */
    public function setCreatedDate(\DateTime $createdDate = null)
    {
        if (is_null($createdDate)) {
            $createdDate = new \DateTime();
        }
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * @param string $createdDate
     *
     * @return $this
     */
    public function setCreatedDateString($createdDate)
    {
        if (!empty($createdDate)) {
            $createdDate = OPGDateFormat::createDateTime($createdDate);
            return $this->setCreatedDate($createdDate);
        }

        return $this->setCreatedDate(new \DateTime());
    }

    /**
     * @return string
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * @return string
     */
    public function getCreatedDateString()
    {
        return $this->createdDate->format(OPGDateFormat::getDateTimeFormat());
    }

}
