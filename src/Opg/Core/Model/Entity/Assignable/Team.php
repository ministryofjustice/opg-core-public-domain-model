<?php


namespace Opg\Core\Model\Entity\Assignable;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\exposeClassname;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Traversable;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity
 *
 * Class Team
 * @package Opg\Core\Model\Entity\Assignable
 */

class Team extends Group implements EntityInterface, \IteratorAggregate, IsAssignee
{
    use InputFilter;
    use ToArray;
    use Assignee;

    /**
     * @ORM\ManyToMany(targetEntity="AssignableComposite", mappedBy="teams")
     */
    protected $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        parent::__construct();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     */
    public function getIterator()
    {
        // TODO: Implement getIterator() method.
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        // TODO: Implement getInputFilter() method.
    }

    public function addMember(AssignableComposite $member)
    {
        if (null === $this->members) {
            $this->members = new ArrayCollection();
        }

        if (false === $this->members->contains($member)) {
            $this->members->add($member);
        }

        return $this;
    }
}
