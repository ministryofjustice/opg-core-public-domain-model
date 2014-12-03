<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Report\AnnualReport;

/**
 * Interface HasAnnualReportsInterface
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
interface HasAnnualReportsInterface
{
    /**
     * @param AnnualReport $report
     * @return HasAnnualReportsInterface
     */
    public function addAnnualReport(AnnualReport $report);

    /**
     * @param ArrayCollection $reports
     * @return HasAnnualReportsInterface
     */
    public function setAnnualReports(ArrayCollection $reports);

    /**
     * @return ArrayCollection
     */
    public function getAnnualReports();

    /**
     * @param AnnualReport $report
     * @return boolean
     */
    public function hasAnnualReport(AnnualReport $report);

    /**
     * @param AnnualReport $report
     * @return HasAnnualReportsInterface
     */
    public function removeAnnualReport(AnnualReport $report);
}
