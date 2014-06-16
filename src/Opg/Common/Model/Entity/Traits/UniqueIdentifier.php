<?php
namespace Opg\Common\Model\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * Class UniqueIdentifier
 * @package Opg\Common\Model\Entity\Traits
 */
trait UniqueIdentifier
{

    /**
     * This is a 12 digit integer unique within the entire system & starts with a 7
     *
     * @ORM\Column(type = "bigint", options = {"unsigned": true}, unique = true)
     * @var int
     * @Type("integer")
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $uId;

    /**
     * (non-PHPdoc)
     * @see \Opg\Common\Model\Entity\UniqueIdentifierInterface::setUid()
     */
    public function setUid($uid)
    {
        $this->uId = (int)$uid;

        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see \Opg\Common\Model\Entity\UniqueIdentifierInterface::getUid()
     */
    public function getUid()
    {
        return $this->uId;
    }
}
