<?php


namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Report\Validation\Validator;


use Zend\Validator\InArray;

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
