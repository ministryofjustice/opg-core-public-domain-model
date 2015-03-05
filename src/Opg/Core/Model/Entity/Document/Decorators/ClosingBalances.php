<?php

namespace Opg\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Opg\Core\Model\Entity\LineItem\LineItem;

/**
 * Class ClosingBalances
 * @package Opg\Core\Model\Entity\Document\Decorators
 */
trait ClosingBalances
{
    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\LineItem\LineItem", mappedBy="document", cascade={"all"},)
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\LineItem\LineItem>")
     */
    protected $closingBalances;

    protected function initClosingBalances()
    {
        if (null === $this->closingBalances) {
            $this->closingBalances = new ArrayCollection();
        }
    }
    /**
     * @return ArrayCollection
     */
    public function getClosingBalances()
    {
       $this->initClosingBalances();

        return $this->closingBalances;
    }

    /**
     * @param \Opg\Core\Model\Entity\LineItem\LineItem $closingBalance
     * @return HasClosingBalances
     */
    public function addClosingBalance(LineItem $closingBalance)
    {
        $this->initClosingBalances();
        $closingBalance->setDocument($this);
        $this->closingBalances->add($closingBalance);

        return $this;
    }

    /**
     * @param ArrayCollection $closingBalances
     * @return HasClosingBalances
     */
    public function setClosingBalances(ArrayCollection $closingBalances)
    {
        $this->closingBalances = new ArrayCollection();

        foreach ($closingBalances as $closingBalance) {
            $this->addClosingBalance($closingBalance);
        }

        return $this;
    }

    /**
     * @param \Opg\Core\Model\Entity\LineItem\LineItem $closingBalance
     * @return boolean
     */
    public function closingBalanceExists(LineItem $closingBalance)
    {
        $this->initClosingBalances();

        return $this->closingBalances->contains($closingBalance);
    }

    /**
     * @param \Opg\Core\Model\Entity\LineItem\LineItem $closingBalance
     * @return HasClosingBalances
     */
    public function removeClosingBalance(LineItem $closingBalance)
    {
        if ($this->closingBalanceExists($closingBalance)) {
            $this->closingBalances->removeElement($closingBalance);
        }

        return $this;
    }
}
