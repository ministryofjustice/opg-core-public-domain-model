<?php
namespace Opg\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\LineItem\LineItem;

interface HasClosingBalances
{
    /**
     * @return ArrayCollection
     */
    public function getClosingBalances();

    /**
     * @param LineItem $lineItem
     * @return HasClosingBalances
     */
    public function addClosingBalance(LineItem $lineItem);

    /**
     * @param ArrayCollection $closingBalances
     * @return HasClosingBalances
     */
    public function setClosingBalances(ArrayCollection $closingBalances);

    /**
     * @param LineItem $lineItem
     * @return boolean
     */
    public function closingBalanceExists(LineItem $lineItem);

    /**
     * @param LineItem $lineItem
     * @return HasClosingBalances
     */
    public function removeClosingBalance(LineItem $lineItem);
}
