<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\Validator;

use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\CaseType as CaseTypeValidator;
use Zend\Validator\Callback;

/**
 * Class CaseSubtype
 *
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Validator
 *
 * @codeCoverageIgnore
 * Anonymous function not covered by unit tests, it is being called but the parser does not see this
 */
class CaseSubtype extends Callback
{
    const CASE_SUB_TYPE_HW = 'hw';
    const CASE_SUB_TYPE_PFA = 'pfa';

    public function __construct()
    {
        $this->setCallback(
            function ($value, $context) {
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
                switch ($caseType) {
                    case CaseTypeValidator::CASE_TYPE_LPA:
                        $validSubtypes = [
                            self::CASE_SUB_TYPE_HW,
                            self::CASE_SUB_TYPE_PFA
                        ];
                        break;

                    case CaseTypeValidator::CASE_TYPE_EPA:
                        $validSubtypes = [
                            self::CASE_SUB_TYPE_HW,
                            self::CASE_SUB_TYPE_PFA
                        ];
                        break;

                    default:
                        // Empty array means all values fail;
                        $validSubtypes = [];
                }

                return in_array(strtolower($value), $validSubtypes);
            }
        );
    }
}
