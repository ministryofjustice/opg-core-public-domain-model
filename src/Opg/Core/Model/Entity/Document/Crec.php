<?php

namespace Opg\Core\Model\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Core\Model\Entity\Document\Decorators\SystemType;
use Opg\Core\Model\Entity\Document\Decorators\HasSystemType;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Document
 */
class Crec extends Document implements HasSystemType
{
    use SystemType;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
     */
    protected $direction = self::DOCUMENT_INTERNAL_CORRESPONDENCE;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Type("integer")
     * @var int
     */
    protected $riskScore;

    /**
     * @return int
     */
    public function getRiskScore()
    {
        return $this->riskScore;
    }

    /**
     * @param int $riskScore
     *
     * @return $this
     */
    public function setRiskScore($riskScore)
    {
        $this->riskScore = intval($riskScore);

        return $this;
    }

}
