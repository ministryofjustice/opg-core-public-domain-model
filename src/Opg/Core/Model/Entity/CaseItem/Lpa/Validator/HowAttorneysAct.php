<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Validator;

use Zend\Validator\InArray;

class HowAttorneysAct extends InArray
{
    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);
        
        $this->setHaystack([
            'JOINTLY',
            'SEVERALLY',
            'JOINTLY_AND_SEVERALLY',
        ]);
    }
}
