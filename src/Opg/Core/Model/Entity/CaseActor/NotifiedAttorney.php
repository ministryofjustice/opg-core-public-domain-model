<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */
class NotifiedAttorney extends Attorney
{
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="setDateAsString",setter="setDateFromString", propertyName="noticeGivenDate")
     * @Type("string")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $noticeGivenDate;

    /**
     * @param \DateTime $noticeGivenDate
     *
     * @return $this
     */
    public function setNoticeGivenDate(\DateTime $noticeGivenDate = null)
    {
        if (is_null($noticeGivenDate)) {
            $noticeGivenDate = new \DateTime();
        }
        $this->noticeGivenDate = $noticeGivenDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getNoticeGivenDate()
    {
        return $this->noticeGivenDate;
    }
}
