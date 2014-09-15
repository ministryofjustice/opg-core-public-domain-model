<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use JMS\Serializer\Annotation\Accessor;
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
     * @Accessor(getter="getNoticeGivenDateString",setter="setNoticeGivenDateString")
     * @Type("string")
     * @Groups("api-task-list")
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
     * @param string $noticeGivenDate
     *
     * @return Epa
     */
    public function setNoticeGivenDateString($noticeGivenDate)
    {
        if (!empty($noticeGivenDate)) {
            $noticeGivenDate = OPGDateFormat::createDateTime($noticeGivenDate);
            $this->setNoticeGivenDate($noticeGivenDate);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getNoticeGivenDate()
    {
        return $this->noticeGivenDate;
    }

    /**
     * @return string
     */
    public function getNoticeGivenDateString()
    {
        if (!empty($this->noticeGivenDate)) {
            return $this->noticeGivenDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }
}
