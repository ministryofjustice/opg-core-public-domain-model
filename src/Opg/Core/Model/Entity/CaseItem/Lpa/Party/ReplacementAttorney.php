<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 *
 * Class ReplacementAttorney
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
class ReplacementAttorney extends AttorneyAbstract
{
    use ExchangeArray;
    use ToArray {
        toArray as traitToArray;
    }

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpaPartCSignatureDateString",setter="setLpaPartCSignatureDateString")
     */
    protected $lpaPartCSignatureDate;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var boolean
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
     *
     * @return Attorney
     */
    public function setIsReplacementAttorney($isReplacementAttorney)
    {
        $this->isReplacementAttorney = $isReplacementAttorney;

        return $this;
    }

    /**
     * @param \DateTime $lpaPartCSignatureDate
     *
     * @return Lpa
     */
    public function setLpaPartCSignatureDate(\DateTime $lpaPartCSignatureDate = null)
    {
        if (is_null($lpaPartCSignatureDate)) {
            $lpaPartCSignatureDate = new \DateTime();
        }
        $this->lpaPartCSignatureDate = $lpaPartCSignatureDate;

        return $this;
    }

    /**
     * @param string $lpaPartCSignatureDate
     *
     * @return Lpa
     */
    public function setLpaPartCSignatureDateString($lpaPartCSignatureDate)
    {
        if (!empty($lpaPartCSignatureDate)) {
            $lpaPartCSignatureDate = OPGDateFormat::createDateTime($lpaPartCSignatureDate);

            if ($lpaPartCSignatureDate) {
                $this->setLpaPartCSignatureDate($lpaPartCSignatureDate);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLpaPartCSignatureDate()
    {
        return $this->lpaPartCSignatureDate;
    }

    /**
     * @return string
     */
    public function getLpaPartCSignatureDateString()
    {
        if (!empty($this->lpaPartCSignatureDate)) {
            return $this->lpaPartCSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }
}
