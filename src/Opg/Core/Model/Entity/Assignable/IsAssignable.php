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
     * @return
     */
    public function getAssignee();

    /**
     * @param IsAssignable $assignee
     * @return IsAssignable
     */
    public function setAssignee(IsAssignable $assignee);
}
