<?php


namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

/**
 * Interface HasCaseRecNumber
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasCaseRecNumber
{
    /**
     * @return string
     */
    public function getCaseRecNumber();

    /**
     * @param string $caseRecNumber
     * @return HasCaseRecNumber
     */
    public function setCaseRecNumber($caseRecNumber);
}
