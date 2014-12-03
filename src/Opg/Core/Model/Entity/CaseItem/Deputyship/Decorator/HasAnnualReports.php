<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Report\AnnualReport;

/**
 * Class HasAnnualReports
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
trait HasAnnualReports
{
    /**
     * @var ArrayCollection
     */
    protected $annualReports;

    protected function initAnnualReports()
    {
        if (null === $this->annualReports) {
            $this->annualReports = new ArrayCollection();
        }
    }

    /**
     * @param AnnualReport $report
     * @return HasAnnualReportsInterface
     */
    public function addAnnualReport(AnnualReport $report)
    {
        $this->initAnnualReports();

        $this->annualReports->add($report);

        return $this;
    }

    /**
     * @param ArrayCollection $reports
     * @return HasAnnualReportsInterface
     */
    public function setAnnualReports(ArrayCollection $reports)
    {
        $this->annualReports = new ArrayCollection();

        foreach ($reports as $report) {
            $this->addAnnualReport($report);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAnnualReports()
    {
        $this->initAnnualReports();

        return $this->annualReports;
    }

    /**
     * @param AnnualReport $report
     * @return boolean
     */
    public function hasAnnualReport(AnnualReport $report)
    {
        $this->initAnnualReports();

        return $this->annualReports->contains($report);
    }

    /**
     * @param AnnualReport $report
     * @return HasAnnualReportsInterface
     */
    public function removeAnnualReport(AnnualReport $report)
    {
        if ($this->hasAnnualReport($report)) {
            $this->annualReports->removeElement($report);
        }

        return $this;
    }
}
