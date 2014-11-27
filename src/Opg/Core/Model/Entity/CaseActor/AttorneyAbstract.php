<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;
use Opg\Core\Model\Entity\CaseActor\Decorators\Company;
use Opg\Core\Model\Entity\CaseActor\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;

/**
 * Class AttorneyAbstract
 * @package Opg\Core\Model\Entity\CaseActor
 */
abstract class AttorneyAbstract extends BasePerson implements HasSystemStatusInterface, HasDateTimeAccessor
{
    use Company;
    use HasSystemStatus;
    use DateTimeAccessor;

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
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="lpaPartCSignatureDate")
     * @Groups("api-person-get")
     */
    protected $lpaPartCSignatureDate;

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
     * @param \DateTime $lpaPartCSignatureDate
     *
     * @return Attorney
     */
    public function setLpaPartCSignatureDate(\DateTime $lpaPartCSignatureDate = null)
    {
        $this->lpaPartCSignatureDate = $lpaPartCSignatureDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLpaPartCSignatureDate()
    {
        return $this->lpaPartCSignatureDate;
    }
}
