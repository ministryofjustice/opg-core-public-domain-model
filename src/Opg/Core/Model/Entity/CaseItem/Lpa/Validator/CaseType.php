<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Validator;

use Zend\Validator\InArray;

/**
 * Class CaseType
 *
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Validator
 */
class CaseType extends InArray
{
    const CASE_TYPE_EPA = 'epa';
    const CASE_TYPE_LPA = 'lpa';

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            array(
                self::CASE_TYPE_EPA,
                self::CASE_TYPE_LPA,
            )
        );
    }
}
