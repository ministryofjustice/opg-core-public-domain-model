<?php

namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\Assignable\Validation\InputFilter\TeamFilter;
use Traversable;
use Zend\InputFilter\InputFilterInterface;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 *
 * Class Team
 * @package Opg\Core\Model\Entity\Assignable
 */
class Team extends AssignableComposite implements EntityInterface, IsAssignee, IsGroupable
{
    use InputFilter;

    /**
     * @ORM\ManyToMany(cascade={"all"}, targetEntity="AssignableComposite", mappedBy="teams")
     * @MaxDepth(2)
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
        $this->members  = new ArrayCollection();
        parent::__construct();
    }

    /**
     * Retrieve input filter
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new \Zend\InputFilter\InputFilter();
            $teamFilter = new TeamFilter();

            foreach ($teamFilter->getInputs() as $input) {
                $this->inputFilter->add($input);
            }
        }

        return $this->inputFilter;
    }

    /**
     * @param AssignableComposite $member
     *
     * @return NullEntity
     */
    public function addMember( AssignableComposite $member )
    {
        if (null === $this->members) {
            $this->members = new ArrayCollection();
        }

        if (false === $this->members->contains( $member )) {
            $this->members->add( $member );
            $member->addTeam($this);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $members
     *
     * @return NullEntity
     */
    public function addMembers( ArrayCollection $members )
    {

        foreach ($members->toArray() as $member) {
            $this->addMember( $member );
        }

        return $this;
    }

    /**
     * @param ArrayCollection $members
     *
     * @return NullEntity
     */
    public function setMembers( ArrayCollection $members )
    {

        if ($this->members instanceof ArrayCollection) {
            $this->members->clear();
        }

        foreach ($members->toArray() as $member) {
            $this->addMember( $member );
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
     * @param AssignableComposite $member
     * @return ArrayCollection
     */
    public function removeMember(AssignableComposite $member)
    {
        if (null === $this->members) {
            $this->members = new ArrayCollection();
        }

        $this->members->removeElement($member);

        return $this;
    }

    /**
     * @param Team $parent
     *
     * @return IsGroupable
     * @throws \LogicException
     */
    public function setParent( Team $parent )
    {
        if (null !== $this->parent) {
            throw new \LogicException( 'Group already has a parent' );
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
     * @param Team $child
     *
     * @return IsGroupable
     */
    public function addChild( Team $child )
    {
        if (null === $this->children) {
            $this->children = new ArrayCollection();
        }

        if (false === $this->children->contains( $child )) {
            $this->children->add( $child );
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
     *
     * @return IsGroupable
     */
    public function addChildren( ArrayCollection $children )
    {
        foreach ($children->toArray() as $child) {
            $this->addChild( $child );
        }

        return $this;
    }

    /**
     * @param $groupName
     *
     * @return NullEntity
     */
    public function setGroupName( $groupName )
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
     *
     * @return IsGroupable
     */
    public function setChildren( ArrayCollection $children )
    {
        if ($this->children instanceof ArrayCollection) {
            $this->children->clear();
        }

        foreach ($children->toArray() as $child) {
            $this->addChild( $child );
        }

        return $this;
    }

    public function getDisplayName()
    {
        return sprintf( '%s (%s)', $this->getName(), $this->getGroupName() );
    }
}
