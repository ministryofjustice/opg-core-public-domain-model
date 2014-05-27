<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use JMS\Serializer\Annotation\Type;

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
     * @Type("string")
     */
    protected $dxExchange;

    /**
     * @param string $dxExchange
     *
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
     *
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
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
