<?php

namespace Opg\Core\Model\Entity;


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
