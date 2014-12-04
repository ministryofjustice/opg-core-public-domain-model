<?php

namespace Opg\Core\Model\Entity\Document\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;

/**
 * Class AnnualReportFilter
 * @package Opg\Core\Model\Entity\Document\Validation\InputFilter
 */
class AnnualReportFilter extends BaseInputFilter
{
    protected function setValidators()
    {
        $this->addValidator('status', 'Opg\Core\Model\Entity\Document\Validation\Validator\AnnualReportStatus');
    }
}
