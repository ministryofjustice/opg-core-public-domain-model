<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class CaseType
 *
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Validator
 */
class CaseType extends InArray
{
    const CASE_TYPE_EPA     = 'EPA';
    const CASE_TYPE_LPA     = 'LPA';
    const CASE_TYPE_ORDER   = 'ORDER';

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            array(
                self::CASE_TYPE_EPA,
                self::CASE_TYPE_LPA,
                self::CASE_TYPE_ORDER
            )
        );
    }
}
