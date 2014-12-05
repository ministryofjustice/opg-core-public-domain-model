<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Fee\Fees;

/**
 * Interface HasFeesInterface
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
interface HasFeesInterface
{
    /**
     * @return ArrayCollection
     */
    public function getFees();

    /**
     * @param ArrayCollection $fees
     * @return HasFeesInterface
     */
    public function setFees(ArrayCollection $fees);

    /**
     * @param Fees $fee
     * @return HasFeesInterface
     */
    public function addFee(Fees $fee);

    /**
     * @param Fees $fee
     * @return boolean
     */
    public function hasFee(Fees $fee);

    /**
     * @param Fees $fee
     * @return HasFeesInterface
     */
    public function removeFee(Fees $fee);
}
