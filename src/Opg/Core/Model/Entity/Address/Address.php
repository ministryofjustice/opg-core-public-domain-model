<?php
namespace Opg\Core\Model\Entity\Address;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;

/**
 * Class Address
 * @package Opg\Core\Model\Entity\Address
 */
class Address implements EntityInterface, \IteratorAggregate
{
    use ToArray;
    use IteratorAggregate;
    use InputFilterTrait;

    /**
     * @var array
     */
    private $addressLines = [];

    /**
     * @var string
     */
    private $town;

    /**
     * @var string
     */
    private $county;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $country;

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

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $data = get_object_vars($this);
        unset($data['inputFilter']);

        return $data;
    }
}
