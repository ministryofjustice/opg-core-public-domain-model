<?php
namespace Opg\Core\Model\Entity\Address;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Person\Person;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

/**
 * @ORM\Entity
 * @ORM\Table(name = "addresses")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * Class Address
 * @package Opg\Core\Model\Entity\Address
 */
class Address implements EntityInterface, \IteratorAggregate
{
    use ToArray;
    use IteratorAggregate;
    use InputFilterTrait;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var integer
     * @Type("integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\Person\Person", inversedBy="addresses")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * @var \Opg\Core\Model\Entity\Person\Person
     * @Type("Opg\Core\Model\Entity\Person\Person")
     */
    protected $person;

    /**
     * @ORM\Column(type = "json_array", name="address_lines")
     * @var array
     * @Type("array")
     */
    protected $addressLines = [];

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $town;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $county;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $postcode;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $country;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $type = 'Primary';

    /**
     * @return \Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'postcode',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 3,
                                    'max'      => 10,
                                ),
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
     * @return array $addressLines
     */
    public function getAddressLines()
    {
        return $this->addressLines;
    }

    /**
     * @param array $addressLines
     *
     * @return Address
     */
    public function setAddressLines(array $addressLines)
    {
        $this->addressLines = $addressLines;
        return $this;
    }

    /**
     * @return Address
     */
    public function clearAddressLines()
    {
        $this->addressLines = [];
        return $this;
    }

    /**
     * @param string $addressLine
     * @return Address
     */
    public function setAddressLine($addressLine)
    {
        $this->addressLines[] = $addressLine;
        return $this;
    }

    /**
     * @return string $town
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * @param string $town
     *
     * @return Address
     */
    public function setTown($town)
    {
        $this->town = (string)$town;

        return $this;
    }

    /**
     * @return string $county
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * @param string $county
     *
     * @return Address
     */
    public function setCounty($county)
    {
        $this->county = (string)$county;

        return $this;
    }

    /**
     * @return string $postcode
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     *
     * @return Address
     */
    public function setPostcode($postcode)
    {
        $this->postcode = (string)$postcode;

        return $this;
    }

    /**
     * @return string $country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = (string)$country;
        return $this;
    }

    /**
     * @param string $type
     * @return Address
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @param int $id
     * @return Address
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Person $person
     *
     * @throws \LogicException
     * @return Address
     */
    public function setPerson(Person $person)
    {
        if($this->person !== null) {
            throw new \LogicException('This address is already linked to a person');
        }
        $this->person = $person;
        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param array $data
     *
     * @return Address
     */
    public function exchangeArray(array $data)
    {
        empty($data['addressLines']) ? : $this->setAddressLines($data['addressLines']);
        empty($data['town']) ? : $this->setTown($data['town']);
        empty($data['postcode']) ? : $this->setPostcode($data['postcode']);
        empty($data['county']) ? : $this->setCounty($data['county']);
        empty($data['country']) ? : $this->setCountry($data['country']);

        return $this;
    }
}
