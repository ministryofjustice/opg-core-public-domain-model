<?php

namespace Opg\Core\Model\Entity\DDC;

use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "ingested_documents")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * Class IngestedDocument
 * @package Opg\Core\Model\Entity\DDC
 */
class IngestedDocument implements HasUidInterface
{
    use UniqueIdentifier;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true})
     * @ORM\GeneratedValue(strategy = "SEQUENCE")
     * @ORM\Id
     * @ORM\SequenceGenerator(sequenceName = "events_seq", initialValue = 1, allocationSize = 20)
     *
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime");
     * @var \DateTime
     */
    protected $ingestedDateTime;

    public function __construct()
    {
        $this->ingestedDateTime = new \DateTime();
    }

    /**
     * @param int $id
     * @return IngestedDocument
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $ingestedDateTime
     * @return IngestedDocument
     */
    public function setIngestedDateTime($ingestedDateTime)
    {
        $this->ingestedDateTime = $ingestedDateTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getIngestedDateTime()
    {
        return $this->ingestedDateTime;
    }


}
