<?php


namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;


use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 *
 * Class ReplacementAttorney
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
class ReplacementAttorney extends AttorneyAbstract
{
    use ExchangeArray;
    use ToArray{
        toArray as traitToArray;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $lpaPartCSignatureDate;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var boolean
     * @Type("boolean")
     */
    protected $isReplacementAttorney = false;

    public function __construct()
    {
        parent::__construct();
        $this->systemStatus = false;
    }

    /**
     * @return boolean $isReplacementAttorney
     */
    public function isReplacementAttorney()
    {
        return $this->isReplacementAttorney;
    }

    /**
     * @param boolean $isReplacementAttorney
     * @return Attorney
     */
    public function setIsReplacementAttorney($isReplacementAttorney)
    {
        $this->isReplacementAttorney = $isReplacementAttorney;
        return $this;
    }

    /**
     * @param string $lpaPartCSignatureDate
     * @return ReplacementAttorney
     */
    public function setLpaPartCSignatureDate($lpaPartCSignatureDate)
    {
        $this->lpaPartCSignatureDate = $lpaPartCSignatureDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getLpaPartCSignatureDate()
    {
        return $this->lpaPartCSignatureDate;
    }

}
