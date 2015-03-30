<?php

namespace Opg\Core\Model\Entity\DDC;

use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;

/**
 * @ORM\Entity
 * @ORM\Table(name = "ingested_documents")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * Class IngestedDocument
 * @package Opg\Core\Model\Entity\DDC
 */
class IngestedDocument implements HasUidInterface, HasIdInterface
{
    use UniqueIdentifier;
    use HasId;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $ingestedDateTime;

    /**
     * @ORM\Column(type="boolean",options={"default":0})
     * @var boolean
     */
    protected $processed;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string
     */
    protected $filename;

    public function __construct()
    {
        $this->ingestedDateTime = new \DateTime();
        $this->processed        = false;
    }

    /**
     * @param \DateTime $ingestedDateTime
     *
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

    /**
     * @param  bool $processed
     *
     * @return IngestedDocument
     */
    public function setProcessed($processed)
    {
        $this->processed = $processed;

        return $this;
    }

    /**
     * @return bool
     */
    public function getProcessed()
    {
        return $this->processed;
    }

    /**
     * @param string $filename
     *
     * @return IngestedDocument
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string $filename
     */
    public function getFilename()
    {
        return $this->filename;
    }
}
