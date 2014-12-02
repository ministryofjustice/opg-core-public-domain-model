<?php

namespace Opg\Core\Model\Entity\CaseActor\Decorators;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasCaseRecNumber;

/**
 * Class CaseRecNumber
 * @package Opg\Core\Model\Entity\CaseActor\Decorators
 */
trait CaseRecNumber
{
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
     */
    protected $caseRecNumber;

    /**
     * @return string
     */
    public function getCaseRecNumber()
    {
        return $this->caseRecNumber;
    }

    /**
     * @param string $caseRecNumber
     * @return HasCaseRecNumber
     */
    public function setCaseRecNumber($caseRecNumber)
    {
        $this->caseRecNumber = $caseRecNumber;

        return $this;
    }
}
