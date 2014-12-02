<?php
namespace Opg\Common\Model\Entity;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 * Class Search
 *
 * @package Opg\Common\Model\Entity;
 */
class Search implements EntityInterface, \IteratorAggregate
{

    use IteratorAggregate;
    use ToArray;
    use InputFilterTrait;

    /**
     * @var string
     */
    private $query;

    /**
     * @param array $data
     *
     * @return Search
     */
    public function exchangeArray(array $data)
    {
        empty($data['query']) ? : $this->setQuery($data['query']);

        return $this;
    }

    /**
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'query',
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
                                    'min'      => 2,
                                    'max'      => 128,
                                ),
                            )
                        )
                    )
                )
            );

            $this->inputFilter->merge($inputFilter);
        }

        return $this->inputFilter;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param string $query
     *
     * @return Search
     */
    public function setQuery($query)
    {
        $this->query = (string)$query;

        return $this;
    }
}
