<?php


namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class Assignee
 * @package Opg\Core\Model\Entity\Assignee
 */
trait Assignee
{
    /**
     * @var AssignableComposite
     */
    protected $assignee;

    /**
     * @return boolean
     */
    public function isAssigned()
    {
        return (null !== $this->assignee);
    }

    /**
     * @return AssignableComposite
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param AssignableComposite $assignee
     * @return IsAssignable
     */
    public function assign(AssignableComposite $assignee)
    {
        $this->assignee = $assignee;

        return $this;
    }

}
