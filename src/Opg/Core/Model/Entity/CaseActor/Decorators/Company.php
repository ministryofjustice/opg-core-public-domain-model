<?php
namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Opg\Core\Model\Entity\CaseActor\PartyInterface;
use JMS\Serializer\Annotation\Groups;

/**
 * Class Company
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Traits
 */
trait Company
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
     */
    protected $companyName;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
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
     *
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
     *
     * @return PartyInterface
     */
    public function setCompanyNumber($companyNumber)
    {
        $this->companyNumber = $companyNumber;

        return $this;
    }
}
