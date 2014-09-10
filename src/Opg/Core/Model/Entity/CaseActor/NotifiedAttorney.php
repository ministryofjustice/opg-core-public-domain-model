<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class NotifiedAttorney extends Attorney
{
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getEpaNotifiedAttorneyNoticeGivenDateString",setter="setEpaNotifiedAttorneyNoticeGivenDateString")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $noticeGivenDate;
    
}
