<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\Person\Person;
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

    /**
     * @param Person $person
     * @return CaseItem
     * @throws \LogicException
     */
    public function addPerson(Person $person)
    {
        if ($person instanceof Attorney) {
            $this->addAttorney($person);
        } elseif ($person instanceof CertificateProvider) {
            $this->addCertificateProvider($person);
        } elseif ($person instanceof NotifiedPerson) {
            $this->addNotifiedPerson($person);
        } elseif ($person instanceof Correspondent) {
            $this->setCorrespondent($person);
        } elseif ($person instanceof Donor) {
            $this->setDonor($person);
        } else {
            throw new \LogicException(__CLASS__ . ' does not support a person of type ' . get_class($person));
        }
        return $this;
    }

}
