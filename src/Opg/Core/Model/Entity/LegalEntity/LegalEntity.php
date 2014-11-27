<?php

namespace Opg\Core\Model\Entity\LegalEntity;

use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\HasDocumentsInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasTasksInterface;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\Traits\HasDocuments;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Common\Model\Entity\Traits\HasTasks;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Common\Model\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Class LegalEntity
 * @package Opg\Core\Model\LegalEntity
 */
abstract class LegalEntity
    implements HasUidInterface, EntityInterface, HasDateTimeAccessor, HasDocumentsInterface, HasNotesInterface,
    \IteratorAggregate, HasTasksInterface, HasIdInterface
{
    use ToArray;
    use UniqueIdentifier;
    use DateTimeAccessor;
    use HasDocuments;
    use HasNotes;
    use InputFilter;
    use HasTasks;
    use HasId;

    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }
}
