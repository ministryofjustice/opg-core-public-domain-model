<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Decorators\NoticeGivenDate;
use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasNoticeGivenDate;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasRelationshipToDonor;

/**
 * @ORM\Entity
 */
class NotifiedRelative extends NonCaseContact implements HasRelationshipToDonor, HasDateTimeAccessor, HasNoticeGivenDate
{
    use RelationshipToDonor;
    use DateTimeAccessor;
    use NoticeGivenDate;
}
