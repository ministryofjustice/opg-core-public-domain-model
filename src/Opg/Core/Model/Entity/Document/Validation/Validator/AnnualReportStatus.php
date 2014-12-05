<?php

namespace Opg\Core\Model\Entity\Document\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class AnnualReportStatus
 * @package Opg\Core\Model\Entity\Document\Validation\Validator
 */
class AnnualReportStatus extends InArray
{
    static $reportStatus = array(
        "Staff Review",
        "Random Review",
        "Neither"
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);
        $this->setHaystack(self::$reportStatus);
    }
}
