<?php

namespace Opg\Core\Model\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use Opg\Core\Model\Entity\Document\Decorators\HasSystemType;
use Opg\Core\Model\Entity\Document\Decorators\SystemType;

/**
 * @ORM\Entity
 * ORM\entity(repositoryClass="Application\Model\Repository\DocumentRepository")
 *
 * Class Correspondence
 * @package Opg\Core\Model\Entity\Document
 */
class OutgoingDocument extends Document implements HasSystemType
{
    use SystemType;

    /**
     * @Type("string")
     * @Accessor(getter="getDirection")
     * @ReadOnly
     * @Groups({"api-person-get"})
     */
    protected $direction = self::DOCUMENT_OUTGOING_CORRESPONDENCE;


    public function __construct()
    {
        $this->createdDate = new \DateTime();
    }
}
