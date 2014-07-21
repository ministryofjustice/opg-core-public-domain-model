<?php
namespace Opg\Common\Model\Entity\Traits;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;

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
     * @Type("string")
     * @Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getUidString", setter="setUidString")
     */
    protected $uId;

    /**
     * @var
     * @readOnly
     * @Accessor(getter="getUid")
     */
    protected $normalizedUid;

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

    /**
     * The front end user would prefer this as a formatted string
     * @return string
     */
    public function getUidString()
    {
        return preg_replace('/^(\d{4})(\d{4})(\d{4})$/',"$1-$2-$3", $this->uId);
    }

    /**
     * @param string $uidString
     * @return $this
     */
    public function setUidString($uidString)
    {
        $this->uId =  preg_replace("/[^\d]/", "", $uidString);

        return $this;
    }
}
