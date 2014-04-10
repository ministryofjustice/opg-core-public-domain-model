<?php


namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * @ORM\Entity
 * 
 * Class TrustCorporation
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
class TrustCorporation extends AttorneyAbstract
{
    use ToArray;
    use ExchangeArray;

    const AS_ATTORNEY               = 'Attorney';
    const AS_REPLACEMENT_ATTORNEY   = 'Replacement Attorney';

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $trustCorporationAppointedAs;

    /**
     * @param string $trustCorporationAppointedAs
     * @return TrustCorporation
     */
    public function setTrustCorporationAppointedAs($trustCorporationAppointedAs)
    {
        $this->trustCorporationAppointedAs = $trustCorporationAppointedAs;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrustCorporationAppointedAs()
    {
        return $this->trustCorporationAppointedAs;
    }
}
