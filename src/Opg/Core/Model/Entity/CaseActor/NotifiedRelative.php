<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\HasRelationshipToDonor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Doctrine\ORM\Mapping as ORM;

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
}
