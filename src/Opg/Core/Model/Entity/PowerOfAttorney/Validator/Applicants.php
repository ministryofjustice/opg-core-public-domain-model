<?php
namespace Opg\Core\Model\Entity\PowerOfAttorney\Validator;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;
use Zend\Validator\AbstractValidator;

/**
 * Class Applicants
 *
 * @package Opg\Core\Model\Entity\PowerOfAttorney\Validator
 */
class Applicants extends AbstractValidator
{
    const INVALID_PARTY_TYPE        = 'invalidPartyType';
    const INVALID_PARTY_COMBINATION = 'invalidPartyCombination';
    const NO_APPLICANTS_FOUND       = 'noApplicantsFound';

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::INVALID_PARTY_TYPE =>
            'Only donors or attorneys are allowed as applicants',
        self::INVALID_PARTY_COMBINATION =>
            'An applicant collection must be either (a) a donor, or (b) one or more attorneys',
        self::NO_APPLICANTS_FOUND =>
            'There must be at least one applicant'
    );

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param mixed $applicants
     *
     * @return bool
     */
    public function isValid(
        $applicants
    ) {
        $this->setValue($applicants);

        $applicantCount = count($applicants);

        $donorCount = 0;
        $attorneyCount = 0;

        foreach ($applicants as $applicant) {

            if ($applicant instanceof \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor) {
                $donorCount ++;
            } elseif ($applicant instanceof \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney) {
                $attorneyCount ++;
            } else {
                $this->error(self::INVALID_PARTY_TYPE);
                return false;
            }
        }

        if ($donorCount >= 1 && $applicantCount > 1) {
            $this->error(self::INVALID_PARTY_COMBINATION);
            return false;
        }

        return true;
    }
}
