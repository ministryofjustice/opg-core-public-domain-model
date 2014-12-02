<?php
namespace Opg\Core\Model\Entity\CaseItem;

/**
 * Interface CaseItemInterface
 * @package Opg\Core\Model\Entity\CaseItem
 */
interface CaseItemInterface
{
    /**
     * @return string $dueDate
     */
    public function getDueDate();

    /**
     * @param \DateTime $dueDate
     */
    public function setDueDate(\DateTime $dueDate);

    /**
     * @return string $caseType
     */
    public function getCaseType();

    /**
     * @param string $caseType
     */
    public function setCaseType($caseType);

    /**
     * @return string $caseSubtype
     */
    public function getCaseSubtype();

    /**
     * @param string $caseSubtype
     */
    public function setCaseSubtype($caseSubtype);

    /**
     * @return string $status
     */
    public function getStatus();

    /**
     * @param string $status
     */
    public function setStatus($status);

}
