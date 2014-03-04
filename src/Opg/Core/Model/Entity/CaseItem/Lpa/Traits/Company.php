<?php

/**
 * @package Opg Core Domain Model
 */

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Traits;

trait Company
{
    /**
     * @var string
     */
    private $companyName;
    
    /**
     * @var string
     */
    private $companyNumber;
    
    /**
     * @return string $companyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return PartyInterface
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string $companyNumber
     */
    public function getCompanyNumber()
    {
        return $this->companyNumber;
    }

    /**
     * @param string $companyNumber
     * @return PartyInterface
     */
    public function setCompanyNumber($companyNumber)
    {
        $this->companyNumber = $companyNumber;
        return $this;
    }
}
