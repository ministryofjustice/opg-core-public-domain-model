<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use Opg\Common\Model\Entity\HasTasksInterface;
use Opg\Core\Model\Entity\Task\Task;

/**
 * Class HasTasks
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasTasks
{
    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\Task\Task", fetch="EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @ReadOnly
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     * @Accessor(getter="filterTasks")
     */
    protected $tasks;

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        if (null === $this->tasks) {
            $this->tasks = new ArrayCollection();
        }

        return $this->tasks;
    }

    /**
     * @param ArrayCollection $tasks
     *
     * @return HasTasksInterface
     */
    public function setTasks( ArrayCollection $tasks )
    {
        foreach ($tasks->toArray() as $task) {
            $this->addTask( $task );
        }

        return $this;
    }

    /**
     * @param Task $task
     *
     * @return HasTasksInterface
     */
    public function addTask( Task $task )
    {
        if (null === $this->tasks) {
            $this->tasks = new ArrayCollection();
        }

        $this->tasks->add( $task );

        return $this;
    }

    /**
     * returns ActiveTasks
     * @return ArrayCollection
     */
    public function filterTasks()
    {
        $activeTasks = new ArrayCollection();

        if(!empty($this->tasks)) {
            foreach ($this->tasks as $taskItem) {
                if($taskItem->getActiveDate() !== null) {
                    $now = time();
                    $taskTime = $taskItem->getActiveDate()->getTimestamp();

                    if ($now >= $taskTime) {
                        $activeTasks->add($taskItem);
                    }
                }
                else {
                    $activeTasks->add($taskItem);
                }
            }
        }
        return $activeTasks;
    }

}
