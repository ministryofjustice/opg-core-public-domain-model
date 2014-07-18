<?php

namespace Opg\Core\Model\Entity\Assignable;

/**
 * Interface IsAssignable
 * @package Opg\Core\Model\Entity
 *
 * For case/task etc
 */
interface IsAssignable
{
    /**
     * @return boolean
     */
    public function isAssigned();

    /**
     * @return AssignableComposite
     */
    public function getAssignee();

    /**
     * @param AssignableComposite $assignee
     * @return IsAssignable
     */
    public function assign(AssignableComposite $assignee);
}
