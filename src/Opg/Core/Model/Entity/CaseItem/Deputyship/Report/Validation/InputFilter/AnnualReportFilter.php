<?php


namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Report\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;

class AnnualReportFilter extends BaseInputFilter
{
    protected function setValidators()
    {
        $this->addValidator('status', 'Opg\Core\Model\Entity\CaseItem\Deputyship\Report\Validation\Validator\AnnualReportStatus');
    }
}
