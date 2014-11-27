<?php

namespace Opg\Core\Model\Entity\LegalEntity;

use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Common\Model\Entity\HasDocumentsInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasTasksInterface;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\Traits\HasDocuments;
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
    \IteratorAggregate, HasTasksInterface
{
    use ToArray;
    use UniqueIdentifier;
    use DateTimeAccessor;
    use HasDocuments;
    use HasNotes;
    use InputFilter;
    use HasTasks;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true})
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Id
     * @var integer
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $id;

    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param  string $id
     *
     * @return LegalEntity
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }
}
