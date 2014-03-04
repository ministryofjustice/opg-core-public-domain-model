<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Opg\Common\Model\Entity\Traits\ToArray as ToArrayTrait;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Core\Model\Entity\CaseItem\Traits\CaseItem as CaseItemTrait;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Party\PartyCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter\LpaFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItemInterface;

/**
 * Class Lpa
 *
 * @package Opg Core
 */
class Lpa implements EntityInterface, \IteratorAggregate, CaseItemInterface
{
    use InputFilterTrait;
    use CaseItemTrait{
        toArray as traitToArray;
    }

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var Donor
     */
    private $donor;

    /**
     * @var Correspondent
     */
    private $correspondent;

    /**
     * @var PartyCollection
     */
    private $applicantCollection;

    /**
     * @var PartyCollection
     */
    private $attorneyCollection;

    /**
     * @var PartyCollection
     */
    private $notifiedPersonCollection;

    /**
     * @var PartyCollection
     */
    private $certificateProviderCollection;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * @var string
     */
    private $cardPaymentContact;

    /**
     * @var string
     */
    private $bacsPaymentInstructions;

    /**
     * @var string
     */
    private $registrationDueDate;

    /**
     * @var string
     */
    private $howAttorneysAct;

    /**
     * @var string
     */
    private $howReplacementAttorneysAct;

    /**
     * @var string
     */
    private $attorneyActDecisions;

    /**
     * @var string
     */
    private $replacementAttorneyActDecisions;

    /**
     * @var string
     */
    private $replacementOrder;

    /**
     * @var string
     */
    private $restrictions;

    /**
     * @var string
     */
    private $guidance;

    /**
     * @var string
     */
    private $charges;

    /**
     * @var string
     */
    private $additionalInfo;

    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var string
     */
    private $paymentAmount;

    /**
     * @var string
     */
    private $paymentDate;

    /**
     * @return string $title
     * @return Lpa
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string $paymentMethod
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     * @return Lpa
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     * @return string $cardPaymentContact
     */
    public function getCardPaymentContact()
    {
        return $this->cardPaymentContact;
    }

    /**
     * @param string $cardPaymentContact
     * @return Lpa
     */
    public function setCardPaymentContact($cardPaymentContact)
    {
        $this->cardPaymentContact = $cardPaymentContact;

        return $this;
    }

    /**
     * @return string $bacsPaymentInstructions
     */
    public function getBacsPaymentInstructions()
    {
        return $this->bacsPaymentInstructions;
    }

    /**
     * @param string $bacsPaymentInstructions
     * @return Lpa
     */
    public function setBacsPaymentInstructions($bacsPaymentInstructions)
    {
        $this->bacsPaymentInstructions = $bacsPaymentInstructions;

        return $this;
    }

    /**
     * @return string $registrationDueDate
     */
    public function getRegistrationDueDate()
    {
        return $this->registrationDueDate;
    }

    /**
     * @param string $registrationDueDate
     * @return Lpa
     */
    public function setRegistrationDueDate($registrationDueDate)
    {
        $this->registrationDueDate = $registrationDueDate;

        return $this;
    }

    /**
     * @return string $howAttorneysAct
     */
    public function getHowAttorneysAct()
    {
        return $this->howAttorneysAct;
    }

    /**
     * @param string $howAttorneysAct
     * @return Lpa
     */
    public function setHowAttorneysAct($howAttorneysAct)
    {
        $this->howAttorneysAct = $howAttorneysAct;

        return $this;
    }

    /**
     * @return string $howReplacementAttorneysAct
     */
    public function getHowReplacementAttorneysAct()
    {
        return $this->howReplacementAttorneysAct;
    }

    /**
     * @param string $howReplacementAttorneysAct
     * @return Lpa
     */
    public function setHowReplacementAttorneysAct($howReplacementAttorneysAct)
    {
        $this->howReplacementAttorneysAct = $howReplacementAttorneysAct;

        return $this;
    }

    /**
     * @return string $attorneyActDecisions
     */
    public function getAttorneyActDecisions()
    {
        return $this->attorneyActDecisions;
    }

    /**
     * @param string $attorneyActDecisions
     * @return Lpa
     */
    public function setAttorneyActDecisions($attorneyActDecisions)
    {
        $this->attorneyActDecisions = $attorneyActDecisions;

        return $this;
    }

    /**
     * @return string $replacementAttorneyActDecisions
     */
    public function getReplacementAttorneyActDecisions()
    {
        return $this->replacementAttorneyActDecisions;
    }

    /**
     * @param string $replacementAttorneyActDecisions
     * @return Lpa
     */
    public function setReplacementAttorneyActDecisions($replacementAttorneyActDecisions)
    {
        $this->replacementAttorneyActDecisions = $replacementAttorneyActDecisions;

        return $this;
    }

    /**
     * @return string $replacementOrder
     */
    public function getReplacementOrder()
    {
        return $this->replacementOrder;
    }

    /**
     * @param string $replacementOrder
     * @return Lpa
     */
    public function setReplacementOrder($replacementOrder)
    {
        $this->replacementOrder = $replacementOrder;

        return $this;
    }

    /**
     * @return string $restrictions
     */
    public function getRestrictions()
    {
        return $this->restrictions;
    }

    /**
     * @param string $restrictions
     * @return Lpa
     */
    public function setRestrictions($restrictions)
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    /**
     * @return string $guidance
     */
    public function getGuidance()
    {
        return $this->guidance;
    }

    /**
     * @param string $guidance
     * @return Lpa
     */
    public function setGuidance($guidance)
    {
        $this->guidance = $guidance;

        return $this;
    }

    /**
     * @return string $charges
     */
    public function getCharges()
    {
        return $this->charges;
    }

    /**
     * @param string $charges
     * @return Lpa
     */
    public function setCharges($charges)
    {
        $this->charges = $charges;

        return $this;
    }

    /**
     * @return string $additionalInfo
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     * @param string $additionalInfo
     * @return Lpa
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    /**
     * @return string $paymentId
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param string $paymentId
     * @return Lpa
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     * @return string $paymentAmount
     */
    public function getPaymentAmount()
    {
        return $this->paymentAmount;
    }

    /**
     * @param string $paymentAmount
     * @return Lpa
     */
    public function setPaymentAmount($paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;

        return $this;
    }

    /**
     * @return string $paymentDate
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param string $paymentDate
     * @return Lpa
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor $donor
     */
    public function getDonor()
    {
        return $this->donor;
    }

    /**
     * @param \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor $donor
     * @return Lpa
     */
    public function setDonor(
        Donor $donor
    ) {
        $this->donor = $donor;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent $correspondent
     */
    public function getCorrespondent()
    {
        return $this->correspondent;
    }

    /**
     * @param \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent $correspondent
     * @return Lpa
     */
    public function setCorrespondent(
        Correspondent $correspondent
    ) {
        $this->correspondent = $correspondent;

        return $this;
    }

    /**
     * @return PartyCollection $applicantCollection
     * @return Lpa
     */
    public function getApplicantCollection()
    {
        return $this->applicantCollection;
    }

    /**
     * @param ApplicantCollection $applicantCollection
     * @return $this
     */
    public function setApplicantCollection(
        ApplicantCollection $applicantCollection
    ) {
        $this->applicantCollection = $applicantCollection;

        return $this;
    }

    /**
     * @return PartyCollection $attorneyCollection
     */
    public function getAttorneyCollection()
    {
        return $this->attorneyCollection;
    }

    /**
     * @param PartyCollection $attorneyCollection
     * @return Lpa
     */
    public function setAttorneyCollection(
        PartyCollection $attorneyCollection
    ) {
        $this->attorneyCollection = $attorneyCollection;

        return $this;
    }

    /**
     * @return PartyCollection $notifiedPersonCollection
     */
    public function getNotifiedPersonCollection()
    {
        return $this->notifiedPersonCollection;
    }

    /**
     * @param PartyCollection $notifiedPersonCollection
     * @return Lpa
     */
    public function setNotifiedPersonCollection(
        PartyCollection $notifiedPersonCollection
    ) {
        $this->notifiedPersonCollection = $notifiedPersonCollection;

        return $this;
    }

    /**
     * @return PartyCollection $certificateProviderCollection
     */
    public function getCertificateProviderCollection()
    {
        return $this->certificateProviderCollection;
    }

    /**
     * @param PartyCollection $certificateProviderCollection
     * @return Lpa
     */
    public function setCertificateProviderCollection(
        PartyCollection $certificateProviderCollection
    ) {
        $this->certificateProviderCollection = $certificateProviderCollection;

        return $this;
    }

    /**
     * @param array $data
     * @return EntityInterface
     */
    public function exchangeArray(array $data)
    {
        empty($data['caseId']) ? : $this->setCaseId($data['caseId']);
        empty($data['status']) ? : $this->setStatus($data['status']);

        return $this;
    }

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
     * @return array
     */
    public function toArray()
    {
        $data = $this->traitToArray();
        unset($data['inputFilter']);

        if ($data['applicantCollection'] instanceof ApplicantCollection) {
            $data['applicantCollection'] = $data['applicantCollection']->toArray();
        }
        if ($data['attorneyCollection'] instanceof PartyCollection) {
            $data['attorneyCollection'] = $data['attorneyCollection']->toArray();
        }
        if ($data['notifiedPersonCollection'] instanceof PartyCollection) {
            $data['notifiedPersonCollection'] = $data['notifiedPersonCollection']->toArray();
        }
        if ($data['certificateProviderCollection'] instanceof PartyCollection) {
            $data['certificateProviderCollection'] = $data['certificateProviderCollection']->toArray();
        }

        return $data;
    }
}
