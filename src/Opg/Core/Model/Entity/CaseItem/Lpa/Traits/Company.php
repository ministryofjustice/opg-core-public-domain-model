<?php

/**
 * @package Opg Core Domain Model
 */

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Traits;

use Doctrine\ORM\Mapping as ORM;

trait Company
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $companyName;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $companyNumber;

    /**
     * @return string $companyName
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface
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
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface
     */
    public function setCompanyNumber($companyNumber)
    {
        $this->companyNumber = $companyNumber;
        return $this;
    }
}
