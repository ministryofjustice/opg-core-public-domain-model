<?php
namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Groups;

/**
 * Class NoticeGivenDate
 * @package Opg\Core\Model\Entity\CaseActor\Decorators
 */
trait NoticeGivenDate
{
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="noticeGivenDate")
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
