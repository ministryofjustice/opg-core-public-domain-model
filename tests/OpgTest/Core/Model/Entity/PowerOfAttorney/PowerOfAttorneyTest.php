<?php

namespace OpgTest\Core\Model\Entity\CaseItem\PowerOfAttorney;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\CaseActor\Attorney;
use Opg\Core\Model\Entity\CaseActor\CertificateProvider;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class PowerOfAttorneyStub extends  PowerOfAttorney
{
    public function addPerson(Person $person)
    {
        return $this;
    }

    public function __unset($key)
    {
        switch($key) {
            case 'applicants' :
                $this->applicants = null;
                break;
            case 'notifiedPersons' :
                $this->notifiedPersons = null;
                break;
            case 'attorneys' :
                $this->attorneys = null;
                break;
            case 'certificateProviders' :
                $this->certificateProviders = null;
                break;
        }
    }
}
class PowerOfAttorneyTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var PowerOfAttorney
     */
    protected $poa;

    public function setUp()
    {
        $this->poa = new PowerOfAttorneyStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->poa instanceof PowerOfAttorney);
    }

    public function testGetSetAttorneys()
    {
        $attorneys = $this->poa->getAttorneys();

        for($i=0;$i<5;$i++) {
            $attorneys->add(new Attorney());
        }

        $this->poa->setAttorneys($attorneys);

        $this->assertEquals($attorneys, $this->poa->getAttorneys());
    }

    public function testGetSetNotifiedPersons()
    {
        $notfiedPersons = $this->poa->getNotifiedPersons();

        for($i=0;$i<5;$i++) {
            $notfiedPersons->add(new NotifiedPerson());
        }

        $this->poa->setNotifiedPersons($notfiedPersons);

        $this->assertEquals($notfiedPersons, $this->poa->getNotifiedPersons());

        unset($this->poa->{'notifiedPersons'});
        $np = new NotifiedPerson();
        $this->poa->addNotifiedPerson($np);
        $this->assertEquals($np, $this->poa->getNotifiedPersons()[0]);

        unset($this->poa->{'notifiedPersons'});
        $this->assertTrue($this->poa->getNotifiedPersons() instanceof ArrayCollection);
    }

    public function testGetSetCertificateProviders()
    {
        unset($this->poa->{'certificateProviders'});
        $certificateProviders = $this->poa->getCertificateProviders();

        for($i=0;$i<5;$i++) {
            $certificateProviders->add(new CertificateProvider());
        }

        $this->poa->setCertificateProviders($certificateProviders);

        $this->assertEquals($certificateProviders, $this->poa->getCertificateProviders());

        unset($this->poa->{'certificateProviders'});
        $cp = new CertificateProvider();
        $this->poa->addCertificateProvider($cp);
        $this->assertEquals($cp, $this->poa->getCertificateProviders()[0]);
    }

    public function testGetSetNotifiedPersonDeclarations()
    {
        $expectedHasNotifiedPersons = true;

        $this->assertFalse($this->poa->hasNotifiedPersons());
        $this->assertEquals('I', $this->poa->getNotifiedPersonPermissionBy());

        $this->poa->setUsesNotifiedPersons($expectedHasNotifiedPersons);
        $this->assertTrue($this->poa->hasNotifiedPersons());

        $this->poa->setNotifiedPersonPermissionBy('We');
        $this->assertEquals('We', $this->poa->getNotifiedPersonPermissionBy());
    }

    public function testGetSetAttorneyPartyDeclarations()
    {
        $this->assertEquals('I', $this->poa->getAttorneyPartyDeclaration());
        $this->poa->setAttorneyPartyDeclaration('We');
        $this->assertEquals('We', $this->poa->getAttorneyPartyDeclaration());
    }

    public function testGetSetCorrespondentCompliance()
    {
        $this->assertEquals('I', $this->poa->getCorrespondentComplianceAssertion());
        $this->poa->setCorrespondentComplianceAssertion('We');
        $this->assertEquals('We', $this->poa->getCorrespondentComplianceAssertion());
    }

    public function testGetSetMentalHealthDeclarations()
    {
        $this->assertEquals('I', $this->poa->getAttorneyMentalActPermission());
        $this->poa->setAttorneyMentalActPermission('We');
        $this->assertEquals('We', $this->poa->getAttorneyMentalActPermission());
    }

    public function testGetSetPayByCard()
    {
        $expectedCardDetails = 'Number 1234567890123456 \n Expiry 01/18\n CCV 123\n Name A Test Card User';

        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentByDebitCreditCard());

        $this->poa
            ->setPaymentByDebitCreditCard(PowerOfAttorney::PAYMENT_OPTION_TRUE)
            ->setCardPaymentContact($expectedCardDetails);

        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getPaymentByDebitCreditCard());

        $this->assertEquals($expectedCardDetails, $this->poa->getCardPaymentContact());
    }

    public function testGetSetPayByCheque()
    {
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentByCheque());
        $this->poa->setPaymentByCheque(PowerOfAttorney::PAYMENT_OPTION_FALSE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE,$this->poa->getPaymentByCheque());
        $this->poa->setPaymentByCheque(PowerOfAttorney::PAYMENT_OPTION_TRUE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE,$this->poa->getPaymentByCheque());
        $this->poa->setPaymentByCheque();
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentByCheque());
    }

    public function testGetSetWouldLikeToApplyForFeeRemission()
    {
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getWouldLikeToApplyForFeeRemission());
        $this->poa->setWouldLikeToApplyForFeeRemission(PowerOfAttorney::PAYMENT_OPTION_TRUE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getWouldLikeToApplyForFeeRemission());
        $this->poa->setWouldLikeToApplyForFeeRemission(PowerOfAttorney::PAYMENT_OPTION_FALSE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getWouldLikeToApplyForFeeRemission());
    }

    public function testGetSetHaveAppliedForFeeRemission()
    {
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getHaveAppliedForFeeRemission());
        $this->poa->setHaveAppliedForFeeRemission(PowerOfAttorney::PAYMENT_OPTION_TRUE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getHaveAppliedForFeeRemission());
        $this->poa->setHaveAppliedForFeeRemission(PowerOfAttorney::PAYMENT_OPTION_FALSE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getHaveAppliedForFeeRemission());
    }

    public function testGetSetCaseAttorneyJointly()
    {
        $this->assertFalse($this->poa->getCaseAttorneyJointly());
        $this->poa->setCaseAttorneyJointly(true);
        $this->assertTrue($this->poa->getCaseAttorneyJointly());
        $this->poa->setCaseAttorneyJointly();
        $this->assertFalse($this->poa->getCaseAttorneyJointly());
    }

    public function testGetSetCaseAttorneyJointlyAndJointlyAndSeverally()
    {
        $this->assertFalse($this->poa->getCaseAttorneyJointlyAndJointlyAndSeverally());
        $this->poa->setCaseAttorneyJointlyAndJointlyAndSeverally(true);
        $this->assertTrue($this->poa->getCaseAttorneyJointlyAndJointlyAndSeverally());
        $this->poa->setCaseAttorneyJointlyAndJointlyAndSeverally();
        $this->assertFalse($this->poa->getCaseAttorneyJointlyAndJointlyAndSeverally());
    }

    public function testGetSetCaseAttorneyJointlyAndSeverally()
    {
        $this->assertFalse($this->poa->getCaseAttorneyJointlyAndSeverally());
        $this->poa->setCaseAttorneyJointlyAndSeverally(true);
        $this->assertTrue($this->poa->getCaseAttorneyJointlyAndSeverally());
        $this->poa->setCaseAttorneyJointlyAndSeverally();
        $this->assertFalse($this->poa->getCaseAttorneyJointlyAndSeverally());
    }

    public function testGetSetCaseAttorneySingular()
    {
        $this->assertFalse($this->poa->getCaseAttorneySingular());
        $this->poa->setCaseAttorneySingular(true);
        $this->assertTrue($this->poa->getCaseAttorneySingular());
        $this->poa->setCaseAttorneySingular();
        $this->assertFalse($this->poa->getCaseAttorneySingular());
    }

    public function testGetSetPaymentDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getPaymentDate());
        $this->assertEmpty($this->poa->getPaymentDateString());

        $this->poa->setPaymentDate($expectedDate);
        $this->assertEquals($expectedDate, $this->poa->getPaymentDate());
    }

    public function testGetSetPaymentDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getPaymentDate());
        $this->poa->setPaymentDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->poa->getPaymentDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetPaymentDateEmptyString()
    {

        $this->assertEmpty($this->poa->getPaymentDate());
        $this->poa->setPaymentDateString('');

        $this->assertEmpty($this->poa->getPaymentDate());
    }

    public function testGetSetPaymentDateInvalidString()
    {
        $this->assertEmpty($this->poa->getPaymentDateString());
        try {
            $this->poa->setPaymentDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }

        $this->assertEmpty($this->poa->getPaymentDateString());

    }

    public function testGetSetPaymentDateValidString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->poa->setPaymentDateString($expected);

        $this->assertEquals($expected, $this->poa->getPaymentDateString());
    }

    public function testGetSetAttorneyApplicationDeclarations()
    {
        $expectedDate = new \DateTime();
        $expectedSignatory = 'Mr Test Signatory';

        $this->assertEquals('I', $this->poa->getAttorneyApplicationAssertion());
        $this->poa->setAttorneyApplicationAssertion('We');
        $this->assertEquals('We', $this->poa->getAttorneyApplicationAssertion());

        $this->poa->setAttorneyDeclarationSignatoryFullName($expectedSignatory);
        $this->poa->setAttorneyDeclarationSignatureDate($expectedDate);

        $this->assertEquals($expectedDate, $this->poa->getAttorneyDeclarationSignatureDate());
        $this->assertEquals($expectedSignatory, $this->poa->getAttorneyDeclarationSignatoryFullName());
    }

    public function testGetSetAttorneyApplicationDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getAttorneyDeclarationSignatureDate());
        $this->poa->setAttorneyDeclarationSignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->poa->getAttorneyDeclarationSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetAttorneyApplicationDateEmptyString()
    {
        $this->assertEmpty($this->poa->getAttorneyDeclarationSignatureDateString());
        $this->poa->setAttorneyDeclarationSignatureDateString('');

        $this->assertEmpty($this->poa->getAttorneyDeclarationSignatureDateString());
    }

    public function testGetSetAttorneyApplicationDateInvalidString()
    {
        $this->assertEmpty($this->poa->getAttorneyDeclarationSignatureDateString());
        try {
            $this->poa->setAttorneyDeclarationSignatureDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }


        $this->assertEmpty($this->poa->getAttorneyDeclarationSignatureDateString());
    }

    public function testGetSetAttorneyApplicationDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->poa->setAttorneyDeclarationSignatureDateString($expected);
        $this->assertEquals($expected, $this->poa->getAttorneyDeclarationSignatureDateString());
    }

    public function testGetSetNotificationDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getNotificationDate());
        $this->assertEmpty($this->poa->getNotificationDateString());

        $this->poa->setNotificationDate($expectedDate);
        $this->assertEquals($expectedDate, $this->poa->getNotificationDate());
    }

    public function testGetSetNotificationDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getNotificationDate());
        $this->poa->setNotificationDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->poa->getNotificationDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetNotificationDateEmptyString()
    {
        $this->assertEmpty($this->poa->getNotificationDateString());
        $this->poa->setNotificationDateString('');
        $this->assertEmpty($this->poa->getNotificationDateString());
    }

    public function testGetSetNotificationDateInvalidString()
    {
        $this->assertEmpty($this->poa->getNotificationDateString());
        try {
            $this->poa->setNotificationDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testGetSetNotificationDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->poa->setNotificationDateString($expected);
        $this->assertEquals($expected, $this->poa->getNotificationDateString());
    }

    public function testGetSetNoticeGivenDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getNoticeGivenDate());
        $this->assertEmpty($this->poa->getNoticeGivenDateString());

        $this->poa->setNoticeGivenDate($expectedDate);
        $this->assertEquals($expectedDate, $this->poa->getNoticeGivenDate());
    }

    public function testGetSetNoticeGivenDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getNoticeGivenDate());
        $this->poa->setNoticeGivenDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->poa->getNoticeGivenDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetNoticeGivenDateEmptyString()
    {
        $this->assertEmpty($this->poa->getNoticeGivenDateString());
        $this->poa->setNoticeGivenDateString('');
        $this->assertEmpty($this->poa->getNoticeGivenDateString());
    }

    public function testGetSetNoticeGivenDateInvalidString()
    {
        $this->assertEmpty($this->poa->getNoticeGivenDateString());
        try {
            $this->poa->setNoticeGivenDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testGetSetNoticeGivenDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->poa->setNoticeGivenDateString($expected);
        $this->assertEquals($expected, $this->poa->getNoticeGivenDateString());
    }

    public function testGetSetDispatchDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getDispatchDate());
        $this->assertEmpty($this->poa->getDispatchDateString());

        $this->poa->setDispatchDate($expectedDate);
        $this->assertEquals($expectedDate, $this->poa->getDispatchDate());
    }

    public function testGetSetDispatchDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getDispatchDate());
        $this->poa->setDispatchDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->poa->getDispatchDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetDispatchDateEmptyString()
    {

        $this->assertEmpty($this->poa->getDispatchDateString());
        $this->poa->setDispatchDateString('');

        $this->assertEmpty($this->poa->getDispatchDateString());
    }

    public function testGetSetDispatchDateInvalidString()
    {
        $this->assertEmpty($this->poa->getDispatchDateString());
        try {
            $this->poa->setDispatchDateString('asddasdsdas');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asddasdsdas' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
    }

    public function testGetSetDispatchDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->poa->setDispatchDateString($expected);
        $this->assertEquals($expected, $this->poa->getDispatchDateString());
    }

    public function testGetSetPaymentExemption()
    {
        $this->assertEquals(Lpa::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentExemption());
        $this->poa->setPaymentExemption(Lpa::PAYMENT_OPTION_FALSE);

        $this->assertEquals(Lpa::PAYMENT_OPTION_FALSE, $this->poa->getPaymentExemption());

    }

    public function testGetSetPaymentRemission()
    {
        $this->assertEquals(Lpa::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentRemission());
        $this->poa->setPaymentRemission(Lpa::PAYMENT_OPTION_FALSE);

        $this->assertEquals(Lpa::PAYMENT_OPTION_FALSE, $this->poa->getPaymentRemission());

    }

    public function testGetSetNoNoticeGiven()
    {
        $this->assertFalse($this->poa->getNoNoticeGiven());

        $this->poa->setNoNoticeGiven(true);

        $this->assertTrue($this->poa->getNoNoticeGiven());
    }

    public function testGetSetApplicants()
    {
        unset($this->poa->{'applicants'});
        $this->assertTrue($this->poa->getApplicants() instanceof ArrayCollection);

        unset($this->poa->{'applicants'});
        $person = (new Donor())->setId(3);

        $this->poa->addApplicant($person);
        $this->assertTrue($this->poa->getApplicants() instanceof ArrayCollection);
        $this->assertEquals($this->poa->getApplicants()->toArray()[0], $person);


    }

    public function testGetSetCancellationDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->poa->getCancellationDate());
        $this->assertTrue($this->poa->setCancellationDate($expected) instanceof PowerOfAttorney);
        $this->assertEquals($expected, $this->poa->getCancellationDate());
    }

    public function testGetSetCancellationDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->poa->getCancellationDateString());
        $this->assertTrue($this->poa->setCancellationDateString($expected) instanceof PowerOfAttorney);
        $this->assertEquals($expected, $this->poa->getCancellationDateString());
    }

    /**
     * @expectedException \Opg\Common\Model\Entity\Exception\InvalidDateFormatException
     */
    public function testGetSetCancellationDateStringFails()
    {
        $expected = 'Invalid date';

        $this->assertEmpty($this->poa->getCancellationDate());
        $this->assertTrue($this->poa->setCancellationDateString($expected) instanceof PowerOfAttorney);
    }

    public function testGetSetApplicantDeclarations()
    {
        $expectedDate = new \DateTime();
        $expectedDateString = $expectedDate->format(OPGDateFormat::getDateFormat());

        $this->assertEquals('I', $this->poa->getApplicantsDeclaration());
        $this->poa->setApplicantsDeclaration('We');
        $this->assertEquals('We', $this->poa->getApplicantsDeclaration());

        $this->assertTrue($this->poa->setApplicantsDeclarationSignatureDate() instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getApplicantsDeclarationSignatureDate());
        $this->assertTrue($this->poa->setApplicantsDeclarationSignatureDateString('') instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getApplicantsDeclarationSignatureDateString());

        $this->assertTrue($this->poa->setApplicantsDeclarationSignatureDate($expectedDate) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDate, $this->poa->getApplicantsDeclarationSignatureDate());
        $this->assertEquals($expectedDateString, $this->poa->getApplicantsDeclarationSignatureDateString());

        $this->assertTrue($this->poa->setApplicantsDeclarationSignatureDateString($expectedDateString) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDateString, $this->poa->getApplicantsDeclarationSignatureDateString());
    }

    public function testGetSetCaseAttorneyActionAdditionalInfo()
    {
        $this->assertFalse($this->poa->getCaseAttorneyActionAdditionalInfo());
        $this->assertTrue($this->poa->setCaseAttorneyActionAdditionalInfo(true) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->getCaseAttorneyActionAdditionalInfo());
    }

    public function testGetSetHasRestrictions()
    {
        $this->assertFalse($this->poa->getApplicationHasRestrictions());
        $this->assertTrue($this->poa->setApplicationHasRestrictions(true) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->getApplicationHasRestrictions());
    }

    public function testGetSetHasGuidance()
    {
        $this->assertFalse($this->poa->getApplicationHasGuidance());
        $this->assertTrue($this->poa->setApplicationHasGuidance(true) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->getApplicationHasGuidance());
    }

    public function testGetSetHasCharges()
    {
        $this->assertFalse($this->poa->getApplicationHasCharges());
        $this->assertTrue($this->poa->setApplicationHasCharges(true) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->getApplicationHasCharges());
    }

    public function testGetSetCertificateProviderSignatureDate()
    {
        $expectedDate = new \DateTime();
        $expectedDateString = $expectedDate->format(OPGDateFormat::getDateFormat());

        $this->assertTrue($this->poa->setCertificateProviderSignatureDate() instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getCertificateProviderSignatureDate());
        $this->assertTrue($this->poa->setCertificateProviderSignatureDateString('') instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getCertificateProviderSignatureDateString());

        $this->assertTrue($this->poa->setCertificateProviderSignatureDate($expectedDate) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDate, $this->poa->getCertificateProviderSignatureDate());
        $this->assertEquals($expectedDateString, $this->poa->getCertificateProviderSignatureDateString());

        $this->assertTrue($this->poa->setCertificateProviderSignatureDateString($expectedDateString) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDateString, $this->poa->getCertificateProviderSignatureDateString());
    }

    public function testGetSetAttorneyStatementDate()
    {
        $expectedDate = new \DateTime();
        $expectedDateString = $expectedDate->format(OPGDateFormat::getDateFormat());

        $this->assertTrue($this->poa->setAttorneyStatementDate() instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getAttorneyStatementDate());
        $this->assertTrue($this->poa->setAttorneyStatementDateString('') instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getAttorneyStatementDateString());

        $this->assertTrue($this->poa->setAttorneyStatementDate($expectedDate) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDate, $this->poa->getAttorneyStatementDate());
        $this->assertEquals($expectedDateString, $this->poa->getAttorneyStatementDateString());

        $this->assertTrue($this->poa->setAttorneyStatementDateString($expectedDateString) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDateString, $this->poa->getAttorneyStatementDateString());
    }

    public function testGetSetSigningOnBehalfDate()
    {
        $expectedDate = new \DateTime();
        $expectedDateString = $expectedDate->format(OPGDateFormat::getDateFormat());

        $this->assertTrue($this->poa->setSigningOnBehalfDate() instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getSigningOnBehalfDate());
        $this->assertTrue($this->poa->setSigningOnBehalfDateString('') instanceof PowerOfAttorney);
        $this->assertEmpty($this->poa->getSigningOnBehalfDateString());

        $this->assertTrue($this->poa->setSigningOnBehalfDate($expectedDate) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDate, $this->poa->getSigningOnBehalfDate());
        $this->assertEquals($expectedDateString, $this->poa->getSigningOnBehalfDateString());

        $this->assertTrue($this->poa->setSigningOnBehalfDateString($expectedDateString) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDateString, $this->poa->getSigningOnBehalfDateString());
    }

    public function testGetSetSigningOnBehalfFullName()
    {
        $expected = 'test signee';

        $this->assertEmpty($this->poa->getSigningOnBehalfFullName());
        $this->assertEquals($expected, $this->poa->setSigningOnBehalfFullName($expected)->getSigningOnBehalfFullName());
    }

    public function testGetSetNormalFeeApplyForRemission()
    {
        $this->poa->setNormalFeeApplyForRemission(null);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getWouldLikeToApplyForFeeRemission());
        $this->assertNull($this->poa->getNormalFeeApplyForRemission());

        $this->poa->setNormalFeeApplyForRemission(false);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getWouldLikeToApplyForFeeRemission());
        $this->assertFalse($this->poa->getNormalFeeApplyForRemission());

        $this->poa->setNormalFeeApplyForRemission(true);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getWouldLikeToApplyForFeeRemission());
        $this->assertTrue($this->poa->getNormalFeeApplyForRemission());
    }

    public function testGetSetNormalHaveAppliedForRemission()
    {
        $this->poa->setNormalHaveAppliedForRemission(null);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getHaveAppliedForFeeRemission());
        $this->assertNull($this->poa->getNormalHaveAppliedForRemission());

        $this->poa->setNormalHaveAppliedForRemission(false);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getHaveAppliedForFeeRemission());
        $this->assertFalse($this->poa->getNormalHaveAppliedForRemission());

        $this->poa->setNormalHaveAppliedForRemission(true);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getHaveAppliedForFeeRemission());
        $this->assertTrue($this->poa->getNormalHaveAppliedForRemission());
    }

    public function testGetSetNormalPaymentRemission()
    {
        $this->poa->setNormalPaymentRemission(null);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentRemission());
        $this->assertNull($this->poa->getNormalPaymentRemission());

        $this->poa->setNormalPaymentRemission(false);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getPaymentRemission());
        $this->assertFalse($this->poa->getNormalPaymentRemission());

        $this->poa->setNormalPaymentRemission(true);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getPaymentRemission());
        $this->assertTrue($this->poa->getNormalPaymentRemission());
    }


    public function testGetSetNormalPaymentExemption()
    {
        $this->poa->setNormalPaymentExemption(null);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentExemption());
        $this->assertNull($this->poa->getNormalPaymentExemption());

        $this->poa->setNormalPaymentExemption(false);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getPaymentExemption());
        $this->assertFalse($this->poa->getNormalPaymentExemption());

        $this->poa->setNormalPaymentExemption(true);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getPaymentExemption());
        $this->assertTrue($this->poa->getNormalPaymentExemption());
    }

    public function testGetSetNormalPaymentByCheque()
    {
        $this->poa->setPaymentByChequeNormalized(null);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentByCheque());
        $this->assertNull($this->poa->getPaymentByChequeNormalized());

        $this->poa->setPaymentByChequeNormalized(false);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getPaymentByCheque());
        $this->assertFalse($this->poa->getPaymentByChequeNormalized());

        $this->poa->setPaymentByChequeNormalized(true);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getPaymentByCheque());
        $this->assertTrue($this->poa->getPaymentByChequeNormalized());
    }

    public function testGetSetPaymentByDebitCreditCardNormalized()
    {
        $this->poa->setPaymentByDebitCreditCardNormalized(null);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getPaymentByDebitCreditCard());
        $this->assertNull($this->poa->getPaymentByDebitCreditCardNormalized());

        $this->poa->setPaymentByDebitCreditCardNormalized(false);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getPaymentByDebitCreditCard());
        $this->assertFalse($this->poa->getPaymentByDebitCreditCardNormalized());

        $this->poa->setPaymentByDebitCreditCardNormalized(true);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getPaymentByDebitCreditCard());
        $this->assertTrue($this->poa->getPaymentByDebitCreditCardNormalized());
    }

    public function testGetSetDonorSignatureWitnessed()
    {
        $this->assertFalse($this->poa->isAttorneyDeclarationSignatureWitnessed());
        $this->assertFalse($this->poa->getAttorneyDeclarationSignatureWitnessed());

        $this->assertTrue($this->poa->setAttorneyDeclarationSignatureWitnessed(true) instanceof PowerOfAttorney);

        $this->assertTrue($this->poa->isAttorneyDeclarationSignatureWitnessed());
        $this->assertTrue($this->poa->getAttorneyDeclarationSignatureWitnessed());
    }

    public function testGEtSetAdditionalInfo()
    {
        $expected = 'test data';
        $expectedDate = new \DateTime();
        $expectedDateString = date('d/m/Y');

        $this->assertEmpty($this->poa->getAdditionalInfo());
        $this->assertEmpty($this->poa->getAdditionalInfoDonorSignatureDate());
        $this->assertEmpty($this->poa->getAdditionalInfoDonorSignatureDateString());
        $this->assertFalse($this->poa->getAdditionalInfoDonorSignature());

        $this->assertTrue($this->poa->setAdditionalInfoDonorSignature(true) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->setAdditionalInfo($expected) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->setAdditionalInfoDonorSignatureDate($expectedDate) instanceof PowerOfAttorney);

        $this->assertEquals($expected, $this->poa->getAdditionalInfo());
        $this->assertEquals($expectedDate, $this->poa->getAdditionalInfoDonorSignatureDate());

        $this->assertTrue($this->poa->setAdditionalInfoDonorSignatureDateString($expectedDateString) instanceof PowerOfAttorney);
        $this->assertEquals($expectedDateString, $this->poa->getAdditionalInfoDonorSignatureDateString());

        $this->assertFalse($this->poa->getAnyOtherInfo());
        $this->assertTrue($this->poa->setAnyOtherInfo(true) instanceof PowerOfAttorney);
        $this->assertTrue($this->poa->getAnyOtherInfo());

    }
}
