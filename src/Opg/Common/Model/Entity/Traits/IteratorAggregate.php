<?php
namespace Opg\Common\Model\Entity\Traits;

/**
 * Class IteratorAggregate
 *
 * @see ToArray
 *
 * @package Opg\Common\Model\Entity\Traits
 */
trait IteratorAggregate
{

    /**
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }
}
