<?php

namespace OpgTest\Core\Model\Entity\PowerOfAttorney;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorneyFactory;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class PowerOfAttorneyTest extends \PHPUnit_Framework_TestCase {

    protected $poa;

    public function setUp()
    {
        $this->poa = $this->getMockForAbstractClass('Opg\\Core\\Model\\Entity\\PowerOfAttorney\\PowerOfAttorney');
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

    }

    public function testGetSetCertificateProviders()
    {
        $certificateProviders = $this->poa->getCertificateProviders();

        for($i=0;$i<5;$i++) {
            $certificateProviders->add(new CertificateProvider());
        }

        $this->poa->setCertificateProviders($certificateProviders);

        $this->assertEquals($certificateProviders, $this->poa->getCertificateProviders());

    }

    public function testFilterThrowsAnError()
    {
        $this->poa->addApplicant(ApplicantFactory::createApplicant(array('className'=>'Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Donor')));
        $this->poa->isValid();

        $this->assertNotEmpty($this->poa->getInputFilter()->getMessages());
        $this->assertEquals(1, count($this->poa->getInputFilter()->getMessages()['caseItems']));
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

    public function testGetSetFeeExemption()
    {
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getFeeExemptionAppliedFor());
        $this->poa->setFeeExemptionAppliedFor(PowerOfAttorney::PAYMENT_OPTION_TRUE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getFeeExemptionAppliedFor());
        $this->poa->setFeeExemptionAppliedFor(PowerOfAttorney::PAYMENT_OPTION_FALSE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getFeeExemptionAppliedFor());
    }

    public function testGetSetFeeRemission()
    {
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_NOT_SET, $this->poa->getFeeRemissionAppliedFor());
        $this->poa->setFeeRemissionAppliedFor(PowerOfAttorney::PAYMENT_OPTION_TRUE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_TRUE, $this->poa->getFeeRemissionAppliedFor());
        $this->poa->setFeeRemissionAppliedFor(PowerOfAttorney::PAYMENT_OPTION_FALSE);
        $this->assertEquals(PowerOfAttorney::PAYMENT_OPTION_FALSE, $this->poa->getFeeRemissionAppliedFor());
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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getPaymentDate());
        $this->poa->setPaymentDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->poa->getPaymentDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
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

    public function testGetSetAttorneyApplicationDateString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getAttorneyDeclarationSignatureDateString());
        $this->poa->setAttorneyDeclarationSignatureDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->poa->getAttorneyDeclarationSignatureDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getNotificationDateString());
        $this->poa->setNotificationDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->poa->getNotificationDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getNoticeGivenDateString());
        $this->poa->setNoticeGivenDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->poa->getNoticeGivenDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getDispatchDateString());
        $this->poa->setDispatchDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->poa->getDispatchDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetRegistrationDueDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getRegistrationDueDate());
        $this->assertEmpty($this->poa->getRegistrationDueDateString());

        $this->poa->setRegistrationDueDate($expectedDate);
        $this->assertEquals($expectedDate, $this->poa->getRegistrationDueDate());
    }

    public function testGetSetRegistrationDueDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getRegistrationDueDate());
        $this->poa->setRegistrationDueDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->poa->getRegistrationDueDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpaReceiptDateEmptyString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->poa->getRegistrationDueDateString());
        $this->poa->setRegistrationDueDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->poa->getRegistrationDueDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
    }


}
