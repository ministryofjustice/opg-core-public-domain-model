<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Funds\CourtFund;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class HasCourtFunds
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
trait HasCourtFunds
{
    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Deputyship\Funds\CourtFund")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="courtfund_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id"="ASC"})
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @var ArrayCollection
     */
    protected $courtFunds;

    protected function initCourtFunds()
    {
        if (null === $this->courtFunds) {
            $this->courtFunds = new ArrayCollection();
        }
    }

    /**
     * @param CourtFund $fund
     * @return HasCourtFundsInterface
     */
    public function addCourtFund(CourtFund $fund)
    {
        $this->initCourtFunds();
        $this->courtFunds->add($fund);

        return $this;
    }

    /**
     * @param ArrayCollection $funds
     * @return HasCourtFundsInterface
     */
    public function setCourtFunds(ArrayCollection $funds)
    {

        $this->courtFunds = new ArrayCollection();

        foreach ($funds as $fund) {
            $this->addCourtFund($fund);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourtFunds()
    {
        $this->initCourtFunds();

        return $this->courtFunds;
    }

    /**
     * @param CourtFund $fund
     * @return boolean
     */
    public function hasCourtFund(CourtFund $fund)
    {
        $this->initCourtFunds();

        return $this->courtFunds->contains($fund);
    }

    /**
     * @param CourtFund $fund
     * @return HasCourtFundsInterface
     */
    public function removeCourtFund(CourtFund $fund)
    {
        if ($this->hasCourtFund($fund)) {
            $this->courtFunds->removeElement($fund);
        }

        return $this;
    }
}
