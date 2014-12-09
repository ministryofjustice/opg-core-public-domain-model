<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseActor\Decorators\NoticeGivenDate;
use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasNoticeGivenDate;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasRelationshipToDonor;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;


/**
 * @ORM\Entity
 */
class NotifiedRelative extends NonCaseContact implements HasRelationshipToDonor, HasNoticeGivenDate
{
    use RelationshipToDonor;
    use NoticeGivenDate;
}
