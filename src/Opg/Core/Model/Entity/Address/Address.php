<?php
namespace Opg\Core\Model\Entity\Address;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseActor\Person;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 * @ORM\Table(name = "addresses")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * Class Address
 * @package Opg\Core\Model\Entity\Address
 */
class Address implements EntityInterface, \IteratorAggregate, HasIdInterface
{
    use ToArray;
    use IteratorAggregate;
    use InputFilterTrait;
    use HasId;

    // Flags
    const INCLUDE_PERSON = 1;
    const EXCLUDE_PERSON = 1;

    // Person name formatting
    const TITLE          = 0b001;
    const FIRSTNAME      = 0b010;
    const SURNAME        = 0b100;
    const DEFAULT_FORMAT = 0b101;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\CaseActor\Person", inversedBy="addresses")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * @var \Opg\Core\Model\Entity\CaseActor\Person
     * @Type("Opg\Core\Model\Entity\CaseActor\Person")
     */
    protected $person;

    /**
     * @ORM\Column(type = "json_array", name="address_lines", nullable = true)
     * @var array
     * @Groups({"api-person-get"})
     */
    protected $addressLines = [];

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $town = '';

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $county = '';

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $postcode = '';

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $country = '';

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-person-get"})
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
                        'required'   => false,
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
                                    'max'      => 50,
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
     *
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
     *
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
     * @param Person $person
     *
     * @throws \LogicException
     * @return Address
     */
    public function setPerson(Person $person)
    {
        if ($this->person !== null && $this->person->getId() != $person->getId()) {
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
     * @param string $delim
     * @param int    $showPerson
     * @param int    $personFormat
     *
     * @return string
     */
    public function toString($delim = "\n", $showPerson = self::EXCLUDE_PERSON, $personFormat = self::DEFAULT_FORMAT)
    {
        $address = [];

        $personEntity = $this->getPerson();
        if (self::INCLUDE_PERSON === $showPerson && !is_null($personEntity)) {
            $person = [];

            if (self::TITLE === ($personFormat & self::TITLE)) {
                $person[] = $personEntity->getTitle();
            }

            if (self::FIRSTNAME === ($personFormat & self::FIRSTNAME)) {
                $person[] = $personEntity->getFirstname();
            }

            if (self::SURNAME === ($personFormat & self::SURNAME)) {
                $person[] = $personEntity->getSurname();
            }

            $address[] = implode(' ', $person);
        }

        // Tidy lines, disregard empty ones.
        $trimmedLines   = array_map('trim', $this->getAddressLines());
        $trimmedLines[] = trim($this->getTown());
        $trimmedLines[] = trim($this->getCounty());
        $trimmedLines[] = trim($this->getPostcode());
        $trimmedLines[] = trim($this->getCountry());

        foreach ($trimmedLines as $line) {
            if (!empty($line)) {
                $address[] = $line;
            }
        }

        return implode($delim, $address);
    }
}
