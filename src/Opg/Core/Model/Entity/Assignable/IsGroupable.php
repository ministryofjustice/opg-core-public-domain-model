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
     * @param AssignableComposite $parent
     * @return IsGroupable
     */
    public function setParent(AssignableComposite $parent);

    /**
     * @return AssignableComposite
     */
    public function getParent();

    /**
     * @param AssignableComposite $child
     * @return IsGroupable
     */
    public function addChild(AssignableComposite $child);

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
