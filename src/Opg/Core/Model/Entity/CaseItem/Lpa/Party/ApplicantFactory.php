<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use \Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;

/**
 * Once we have moved over to a more standardised and flattened way of creating arrays
 * we need to be able to recreate the type of applicant from the array data
 *
 * This is currently best guess so we need to ensure we have a unique way of identifying each
 * applicant type
 *
 * Class ApplicantFactory
 * @package Opg\Core\Model\Entity\CaseItem\Lpa\Party
 */
class ApplicantFactory
{

    /**
     * @param array $data
     *
     * @return $this|null
     * @throws \Exception
     */
    public static function createApplicant(array $data)
    {
        $applicant     = null;
        $applicantType = null;

        if (!empty($data['className'])) {
            if ($data['className'] === "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Donor") {
                $applicantType = new Donor();
                $applicant     = $applicantType->exchangeArray($data);
            } elseif ($data['className'] === "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Attorney") {
                $applicantType = new Attorney();
                $applicant     = $applicantType->exchangeArray($data);
            } elseif ($data['className'] === "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\CertificateProvider") {
                $applicantType = new CertificateProvider();
                $applicant     = $applicantType->exchangeArray($data);
            } elseif ($data['className'] === "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\NotifiedPerson") {
                $applicantType = new NotifiedPerson();
                $applicant     = $applicantType->exchangeArray($data);
            } else {
                $applicantType = new Correspondent();
                $applicant     = $applicantType->exchangeArray($data);
            }
        } else {
            throw new \Exception('Cannot build unknown person type.');
        }

        return $applicant;
    }
}
