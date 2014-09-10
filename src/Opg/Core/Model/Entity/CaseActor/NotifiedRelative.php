<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\HasRelationshipToDonor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 */
class NotifiedRelative extends NonCaseContact implements HasRelationshipToDonor
{
    use RelationshipToDonor;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getEpaNotifiedRelativeNoticeGivenDateString",setter="setEpaNotifiedRelativeNoticeGivenDateString")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $noticeGivenDate;
    
    /**
     * @param \DateTime $noticeGivenDate
     *
     * @return $this
     */
    public function setEpaNotifiedRelativeNoticeGivenDate(\DateTime $noticeGivenDate = null)
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
    public function setEpaNotifiedRelativeNoticeGivenDateString($noticeGivenDate)
    {
        if (!empty($noticeGivenDate)) {
            $noticeGivenDate = OPGDateFormat::createDateTime($noticeGivenDate);
            $this->setEpaNotifiedRelativeNoticeGivenDate($noticeGivenDate);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEpaNotifiedRelativeNoticeGivenDate()
    {
        return $this->noticeGivenDate;
    }

    /**
     * @return string
     */
    public function getEpaNotifiedRelativeNoticeGivenDateString()
    {
        if (!empty($this->noticeGivenDate)) {
            return $this->noticeGivenDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }
}
