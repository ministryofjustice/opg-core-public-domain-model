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

class Team extends AssignableComposite implements EntityInterface, IsAssignee, IsGroupable
{
    use InputFilter;
    use Assignee;

    /**
     * @ORM\ManyToMany(targetEntity="AssignableComposite", mappedBy="teams")
     */
    protected $members;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $groupName;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy = "children")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity = "Team", mappedBy = "parent")
     */
    protected $children;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->members = new ArrayCollection();
        parent::__construct();
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

    /**
     * @param AssignableComposite $parent
     * @return IsGroupable
     * @throws \LogicException
     */
    public function setParent(AssignableComposite $parent)
    {
        if (null !== $this->parent) {
            throw new \LogicException('Group already has a parent');
        }

        $this->parent = $parent;

        return $this;
    }

    /**
     * @return AssignableComposite
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Group $child
     * @return IsGroupable
     */
    public function addChild(AssignableComposite $child)
    {
        if (null === $this->children) {
            $this->children = new ArrayCollection();
        }

        if (false === $this->children->contains($child)) {
            $this->children->add($child);
        }
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param ArrayCollection $children
     * @return IsGroupable
     */
    public function addChildren(ArrayCollection $children)
    {
        foreach ($children->toArray() as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    /**
     * @param $groupName
     * @return $this
     */
    public function setGroupName($groupName)
    {
        $this->groupName = $groupName;

        return $this;
    }

    /**
     * @return string
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @param ArrayCollection $children
     * @return IsGroupable
     */
    public function setChildren(ArrayCollection $children)
    {
        if ($this->children instanceof ArrayCollection) {
            $this->children->clear();
        }

        foreach ($children->toArray() as $child) {
            $this->addChild($child);
        }

        return $this;
    }

    public function getDisplayName()
    {
        return sprintf('%s (%s)', $this->getName(), $this->getGroupName());
    }
}
