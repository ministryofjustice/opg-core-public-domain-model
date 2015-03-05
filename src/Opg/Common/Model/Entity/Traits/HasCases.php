<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\HasCasesInterface;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use JMS\Serializer\Annotation\Type;

/**
 * Class HasCases
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasCases
{

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\CaseItem\CaseItem", cascade={"persist"})
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @Groups({"api-person-get"})
     * @Type("ArrayCollection")
     */
    protected $cases;

    /**
     * @return ArrayCollection
     */
    public function getCases()
    {
        $this->initCases();

        return $this->cases;
    }

    /**
     * @param ArrayCollection $caseCollection
     *
     * @return HasCasesInterface
     */
    public function setCases(ArrayCollection $caseCollection)
    {
        $this->cases = $caseCollection;

        return $this;
    }

    /**
     * @param ArrayCollection $caseCollection
     * @return HasCasesInterface
     */
    public function addCases(ArrayCollection $caseCollection)
    {
        foreach ($caseCollection as $case) {
            $this->addCase($case);
        }

        return $this;
    }

    /**
     * @param CaseItem $caseItem
     * @return HasCasesInterface
     */
    public function addCase(CaseItem $caseItem)
    {
        $this->initCases();

        if (false === $this->cases->contains($caseItem)) {
            $this->cases->add($caseItem);
        }

        return $this;
    }

    /**
     * @param CaseItem $caseItem
     * @return HasCasesInterface
     */
    public function removeCase(CaseItem $caseItem)
    {
        $this->initCases();

        if (true == $this->cases->contains($caseItem)) {
            $this->cases->removeElement($caseItem);
        }

        return $this;
    }

    /**
     * Method to validate a person in the input filter, where required
     * This is a bitwise or comparison, if either condition is true, it returns true
     * @return bool
     *
     */
    public function hasAttachedCase()
    {
        return (bool)($this->getCases()->count() > 0);
    }

    /**
     * @return ArrayCollection
     */
    public function getPowerOfAttorneys()
    {
        return $this->filterCases(HasCasesInterface::CASE_TYPE_POA);
    }


    public function getDeputyships()
    {
        return $this->filterCases(HasCasesInterface::CASE_TYPE_DEP);
    }

    /**
     * @internal
     */
    protected function initCases()
    {
        if (null === $this->cases) {
            $this->cases = new ArrayCollection();
        }
    }

    /**
     * @internal
     * @param string $caseFilter
     * @return ArrayCollection
     */
    protected function filterCases($caseFilter)
    {
        $this->initCases();

        return
            $this->cases->filter(
                function ($item) use ($caseFilter) {
                    return ($item instanceof $caseFilter);
                }
            );
    }
}
