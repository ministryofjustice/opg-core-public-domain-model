<?php


namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;


use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\Orm;
use JMS\Serializer\Annotation\Type;
use Zend\InputFilter\Factory as InputFactory;


/**
 * Class AttorneyAbstract
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
abstract class AttorneyAbstract extends BasePerson implements HasSystemStatusInterface
{
    use Company;
    use HasSystemStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $dxNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $dxExchange;

    /**
     * @param string $dxExchange
     * @return AttorneyAbstract
     */
    public function setDxExchange($dxExchange)
    {
        $this->dxExchange = $dxExchange;
        return $this;
    }

    /**
     * @return string
     */
    public function getDxExchange()
    {
        return $this->dxExchange;
    }

    /**
     * @param string $dxNumber
     * @return AttorneyAbstract
     */
    public function setDxNumber($dxNumber)
    {
        $this->dxNumber = $dxNumber;
        return $this;
    }

    /**
     * @return string
     */
    public function getDxNumber()
    {
        return $this->dxNumber;
    }

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
                        'name'       => 'email',
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
                                    'max'      => 24,
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
}
