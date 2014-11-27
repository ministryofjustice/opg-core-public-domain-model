<?php

namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Task\Task;

/**
 * Interface HasTasksInterface
 * @package Opg\Common\Model\Entity
 */
interface HasTasksInterface
{
    /**
     * @return ArrayCollection
     */
    public function getTasks();

    /**
     * @param Task $task
     * @return HasTasksInterface
     */
    public function addTask(Task $task);

    /**
     * @param ArrayCollection $tasks
     * @return HasTasksInterface
     */
    public function setTasks(ArrayCollection $tasks);
}
