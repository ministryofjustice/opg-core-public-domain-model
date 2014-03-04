<?php

namespace Opg\Core\Model\Entity\CaseItem\Task;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;

/**
 * Class TaskCollection
 *
 * @package Opg Core
 */
class TaskCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $taskCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getTaskCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getTaskCollection();
    }

    /**
     * @return array
     */
    public function getTaskCollection()
    {
        return $this->taskCollection;
    }

    /**
     * @param Task $task
     * @return TaskCollection
     */
    public function addTask(Task $task)
    {
        $this->taskCollection[] = $task;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        foreach ($this->taskCollection as $task) {
            $results[] = $task->toArray();
        }

        return $results;
    }
    
    public function exchangeArray(array $data)
    {
        throw new UnusedException();
    }
    
    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        return new InputFilter();
    }

    /**
     * Sorts tasks in $this->taskCollection by due date ascending.
     * @return TaskCollection
     */
    public function sortByDueDate() {
        // @TODO Remove the @ symbol
        // Please do not remove the @ symbol until this PHP bug is fixed:
        // https://bugs.php.net/bug.php?id=50688
        @usort($this->taskCollection, function(Task $a, Task $b) {
                if ($a->getDueDate() < $b->getDueDate()) { return -1; }
                if ($a->getDueDate() > $b->getDueDate()) { return 1; }
                return 0;
            });

        return $this;
    }
}
