<?php

namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Accessor;

/**
 * Class Assignee
 * @package Opg\Core\Model\Entity\Assignee
 */
trait Assignee
{
    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\Assignable\AssignableComposite", fetch = "EAGER")
     * @MaxDepth(1)
     * @var AssignableComposite
     * @ReadOnly
     * @Groups({"api-case-list","api-task-list","api-person-get","api-warning-list"})
     * @Accessor(getter="getAssignee", setter="setAssignee")
     */
    protected $assignee;

    /**
     * @return boolean
     */
    public function isAssigned()
    {
        return ( null !== $this->assignee );
    }

    /**
     * @return AssignableComposite
     */
    public function getAssignee()
    {
        if (is_null($this->assignee)) {
            return new NullEntity();
        }
        return $this->assignee;
    }

    /**
     * @param AssignableComposite $assignee
     *
     * @return IsAssignable
     */
    public function assign( AssignableComposite $assignee = null )
    {
        if ($assignee instanceof NullEntity) {
            $assignee = null;
        }

        $this->assignee = $assignee;

        return $this;
    }
}
