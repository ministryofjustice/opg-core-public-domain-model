<?php

namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\exposeClassname;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Traversable;
use Zend\InputFilter\InputFilterInterface;
use JMS\Serializer\Annotation\Exclude;

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
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        return new \Zend\InputFilter\InputFilter();
    }

    /**
     * @param AssignableComposite $member
     * @return $this
     */
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

    /**
     * @param ArrayCollection $members
     * @return $this
     */
    public function addMembers(ArrayCollection $members)
    {

        foreach ($members->toArray() as $member) {
            $this->addMember($member);
        }

        return $this;
     }

    /**
     * @param ArrayCollection $members
     * @return $this
     */
    public function setMembers(ArrayCollection $members)
    {

        if ($this->members instanceof ArrayCollection) {
            $this->members->clear();
        }

        foreach ($members->toArray() as $member) {
            $this->addMember($member);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getMembers()
    {
        if (null === $this->members) {
            $this->members = new ArrayCollection();
        }

        return $this->members;
    }
}
