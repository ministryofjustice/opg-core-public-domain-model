<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Core\Model\Entity\CaseActor\Decorators\NoticeGivenDate;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasNoticeGivenDate;

/**
 * @ORM\Entity
 */
class NotifiedAttorney extends Attorney implements HasNoticeGivenDate, HasDateTimeAccessor
{
    use NoticeGivenDate;
    use DateTimeAccessor;
}
