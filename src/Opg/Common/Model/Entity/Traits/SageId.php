<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Opg\Common\Model\Entity\HasSageId;
use Opg\Common\Model\Entity\LuhnCheckDigit;

trait SageId
{
    /**
     * This is a 8 digit integer unique within the entire system & starts with a L
     *
     * @ORM\Column(type = "string", unique=true, nullable=true)
     * @var string
     * @Type("string")
     * @Accessor(setter="setSageId", getter="getSageId")
     * @Groups({"api-case-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $sageId;

    /**
     * @param $uid
     * @return HasSageId
     * @throws \LogicException
     */
    public function generateSageId($uid)
    {
        $uidBase = '';

        if (LuhnCheckDigit::validateNumber($uid) && strlen($uid) === 12) {
            $uidBase = substr((string)$uid, 1, 10);
        } else {
            throw new \LogicException('The uid supplied did not pass validation');
        }

        $this->sageId = strtoupper(sprintf('L%07s' , base_convert($uidBase, 10, 36)));

        return $this;
    }

    /**
     * @return string
     */
    public function getSageId()
    {
        if (null === $this->sageId && isset($this->uId)) {
            $this->generateSageId($this->uId);
        }
        return $this->sageId;
    }

    /**
     * @param $sageId
     * @return HasSageId
     */
    public function setSageId($sageId)
    {
        $this->sageId = $sageId;

        return $this;
    }
}
