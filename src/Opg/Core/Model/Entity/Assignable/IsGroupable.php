<?php

namespace Opg\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface IsGroupable
 * @package Opg\Core\Model\Entity\Assignable
 */
interface IsGroupable
{
    /**
     * @param Group $parent
     * @return IsGroupable
     */
    public function setParent(Group $parent);

    /**
     * @return AssignableComposite
     */
    public function getParent();

    /**
     * @param Group $child
     * @return IsGroupable
     */
    public function addChild(Group $child);

    /**
     * @return ArrayCollection
     */
    public function getChildren();

    /**
     * @param ArrayCollection $children
     * @return IsGroupable
     */
    public function setChildren(ArrayCollection $children);

}
