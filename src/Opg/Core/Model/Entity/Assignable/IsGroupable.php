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
     * @param Team $parent
     * @return IsGroupable
     */
    public function setParent(Team $parent);

    /**
     * @return AssignableComposite
     */
    public function getParent();

    /**
     * @param Team $child
     * @return IsGroupable
     */
    public function addChild(Team $child);

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
