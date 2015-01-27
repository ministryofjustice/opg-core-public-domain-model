<?php

namespace Opg\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\LineItem\LineItem;

/**
 * Class ClosingBalances
 * @package Opg\Core\Model\Entity\Document\Decorators
 */
trait ClosingBalances
{

    /**
     * @var ArrayCollection
     */
    protected $balances;

    protected function initClosingBalances()
    {
        if (null === $this->balances) {
            $this->balances = new ArrayCollection();
        }
    }
    /**
     * @return ArrayCollection
     */
    public function getClosingBalances()
    {
       $this->initClosingBalances();

        return $this->balances;
    }

    /**
     * @param LineItem $closingBalance
     * @return HasClosingBalances
     */
    public function addClosingBalance(LineItem $closingBalance)
    {
        $this->initClosingBalances();
        $this->balances->add($closingBalance);

        return $this;
    }

    /**
     * @param ArrayCollection $closingBalances
     * @return HasClosingBalances
     */
    public function setClosingBalances(ArrayCollection $closingBalances)
    {
        $this->balances = new ArrayCollection();

        foreach ($closingBalances as $closingBalance) {
            $this->addClosingBalance($closingBalance);
        }

        return $this;
    }

    /**
     * @param LineItem $closingBalance
     * @return boolean
     */
    public function closingBalanceExists(LineItem $closingBalance)
    {
        $this->initClosingBalances();

        return $this->balances->contains($closingBalance);
    }

    /**
     * @param LineItem $closingBalance
     * @return HasClosingBalances
     */
    public function removeClosingBalance(LineItem $closingBalance)
    {
        if ($this->closingBalanceExists($closingBalance)) {
            $this->balances->removeElement($closingBalance);
        }

        return $this;
    }
}
