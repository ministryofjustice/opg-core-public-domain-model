<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Validator;

use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\CaseType as CaseTypeValidator;
use Zend\Validator\Callback;

/**
 * Class CaseSubtype
 *
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Validator
 */
class CaseSubtype extends Callback
{
    const CASE_SUB_TYPE_HW = 'hw';
    const CASE_SUB_TYPE_PF = 'pf';

    public function __construct()
    {
        $this->setCallback(function ($value, $context) {
            // SubType validation is automatically successful if this isn't an LPA or EPA...
            $caseTypesWhichRequireValidation = [
                CaseTypeValidator::CASE_TYPE_EPA,
                CaseTypeValidator::CASE_TYPE_LPA
            ];

            $caseType = $context->getCaseType();

            if (!in_array($caseType, $caseTypesWhichRequireValidation)) {
                return true;
            }

            // Prepare a list of valid CaseSubtypes, based on the parent CaseType
            switch($caseType) {
                case CaseTypeValidator::CASE_TYPE_LPA:
                    $validSubtypes = [
                        self::CASE_SUB_TYPE_HW,
                        self::CASE_SUB_TYPE_PW
                    ];
                    break;

                case CaseTypeValidator::CASE_TYPE_EPA:
                    $validSubtypes = [
                        self::CASE_SUB_TYPE_HW,
                        self::CASE_SUB_TYPE_PW
                    ];
                    break;

                default:
                    // Empty array means all values fail;
                    $validSubtypes = [];
            }

            return in_array($value, $validSubtypes);
        });
    }
}
