<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;
use Opg\Core\Model\Entity\CaseActor\Decorators\Company;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;

/**
 * Class AttorneyAbstract
 * @package Opg\Core\Model\Entity\CaseActor
 */
abstract class AttorneyAbstract extends BasePerson implements HasSystemStatusInterface
{
    use Company;
    use HasSystemStatus;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     * @Groups("api-person-get")
     */
    protected $dxNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     * @Groups("api-person-get")
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
}
