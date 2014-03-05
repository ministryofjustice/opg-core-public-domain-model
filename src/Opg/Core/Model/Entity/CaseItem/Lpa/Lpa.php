<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter\LpaFilter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * Class Lpa
 *
 * @package Opg Core
 */
class Lpa extends PowerOfAttorney
{
    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new LpaFilter();
        }

        return $this->inputFilter;
    }
}
