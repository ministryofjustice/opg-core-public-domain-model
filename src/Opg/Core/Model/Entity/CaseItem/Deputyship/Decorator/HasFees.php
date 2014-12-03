<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\Fee\Fees;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasFees
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
trait HasFees
{
    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Fee\Fees", cascade={"persist"})
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     */
    protected $fees;

    protected function initFees()
    {
        if (null === $this->fees) {
            $this->fees = new ArrayCollection();
        }
    }
    /**
     * @return ArrayCollection
     */
    public function getFees()
    {
        $this->initFees();

        return $this->fees;
    }

    /**
     * @param ArrayCollection $fees
     * @return HasFeesInterface
     */
    public function setFees(ArrayCollection $fees)
    {
        foreach ($fees as $fee) {
            $this->addFee($fee);
        }

        return $this;
    }

    /**
     * @param Fees $fee
     * @return HasFeesInterface
     */
    public function addFee(Fees $fee)
    {
        $this->initFees();
        $this->fees->add($fee);

        return $this;
    }

    /**
     * @param Fees $fee
     * @return boolean
     */
    public function hasFee(Fees $fee)
    {
        $this->initFees();

        return $this->fees->contains($fee);
    }

    /**
     * @param Fees $fee
     * @return HasFeesInterface
     */
    public function removeFee(Fees $fee)
    {
        if (true === $this->hasFee($fee)) {
            $this->fees->removeElement($fee);
        }

        return $this;
    }
}
