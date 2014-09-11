<?php

namespace OpgTest\Core\Model\Entity\PowerOfAttorney;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorneyFactory;
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

        unset($this->poa->notifiedPersons);
        $np = new NotifiedPerson();
        $this->poa->addNotifiedPerson($np);
        $this->assertEquals($np, $this->poa->getNotifiedPersons()[0]);
    }

    public function testGetSetCertificateProviders()
    {
        unset($this->poa->certificateProviders);
        $certificateProviders = $this->poa->getCertificateProviders();

        for($i=0;$i<5;$i++) {
            $certificateProviders->add(new CertificateProvider());
        }

        $this->poa->setCertificateProviders($certificateProviders);

        $this->assertEquals($certificateProviders, $this->poa->getCertificateProviders());

        unset($this->poa->certificateProviders);
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
}
