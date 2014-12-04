<?php

namespace Opg\Core\Model\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Core\Model\Entity\Document\Decorators\AssetLog;
use Opg\Core\Model\Entity\Document\Decorators\HasAssetLog;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Document
 */
class LodgingChecklist extends OutgoingDocument implements HasAssetLog
{
    use AssetLog;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
     */
    protected $direction = self::DOCUMENT_INTERNAL_CORRESPONDENCE;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $closingBalance1 = 0;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $closingBalance2 = 0;

    /**
     * @param float $closingBalance1
     * @return LodgingChecklist
     */
    public function setClosingBalance1($closingBalance1)
    {
        $this->closingBalance1 = (float)$closingBalance1;

        return $this;
    }

    /**
     * @return float
     */
    public function getClosingBalance1()
    {
        return $this->closingBalance1;
    }

    /**
     * @param float $closingBalance2
     * @return LodgingChecklist
     */
    public function setClosingBalance2($closingBalance2)
    {
        $this->closingBalance2 = (float)$closingBalance2;

        return $this;
    }

    /**
     * @return float
     */
    public function getClosingBalance2()
    {
        return $this->closingBalance2;
    }


}
