<?php


namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * Class Group
 * @package Opg\Core\Model\Entity\Assignable
 */
abstract class Group extends AssignableComposite implements IsGroupable
{
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $groupName;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy = "children")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity = "Group", mappedBy = "parent")
     */
    protected $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        parent::__construct();
    }

    /**
     * @param Group $parent
     * @return IsGroupable
     * @throws \LogicException
     */
    public function setParent(Group $parent)
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
    public function addChild(Group $child)
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
}
