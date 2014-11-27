<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;

/**
 * @ORM\Entity
 */
class NotifiedRelative extends NonCaseContact implements HasRelationshipToDonor, HasDateTimeAccessor
{
    use RelationshipToDonor;
    use DateTimeAccessor;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString". propertyName="noticeGivenDate")
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
