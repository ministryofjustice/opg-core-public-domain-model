<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Funds\CourtFund;

/**
 * Interface HasCourtFundsInterface
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
interface HasCourtFundsInterface
{
    /**
     * @param CourtFund $fund
     * @return HasCourtFundsInterface
     */
    public function addCourtFund(CourtFund $fund);

    /**
     * @param ArrayCollection $funds
     * @return HasCourtFundsInterface
     */
    public function setCourtFunds(ArrayCollection $funds);

    /**
     * @return ArrayCollection
     */
    public function getCourtFunds();

    /**
     * @param CourtFund $fund
     * @return boolean
     */
    public function hasCourtFund(CourtFund $fund);

    /**
     * @param CourtFund $fund
     * @return HasCourtFundsInterface
     */
    public function removeCourtFund(CourtFund $fund);
}
