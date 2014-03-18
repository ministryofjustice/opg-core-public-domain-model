<?php

namespace OpgTest\Core\Model\Entity\PowerOfAttorney;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorneyFactory;

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
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_SINGULAR, $this->poa->getNotifiedPersonPermissionBy());

        $this->poa->setUsesNotifiedPersons($expectedHasNotifiedPersons);
        $this->assertTrue($this->poa->hasNotifiedPersons());

        $this->poa->setNotifiedPersonPermissionBy(PowerOfAttorney::PERMISSION_GIVEN_PLURAL);
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_PLURAL, $this->poa->getNotifiedPersonPermissionBy());
    }

    public function testGetSetAttorneyPartyDeclarations()
    {
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_SINGULAR, $this->poa->getAttorneyPartyDeclaration());
        $this->poa->setAttorneyPartyDeclaration(PowerOfAttorney::PERMISSION_GIVEN_PLURAL);
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_PLURAL, $this->poa->getAttorneyPartyDeclaration());
    }

    public function testGetSetCorrespondentCompliance()
    {
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_SINGULAR, $this->poa->getCorrespondentComplianceAssertion());
        $this->poa->setCorrespondentComplianceAssertion(PowerOfAttorney::PERMISSION_GIVEN_PLURAL);
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_PLURAL, $this->poa->getCorrespondentComplianceAssertion());
    }

    public function testGetSetAttorneyApplicationDeclarations()
    {
        $expectedDate = new \DateTime();
        $expectedSignatory = 'Mr Test Signatory';

        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_SINGULAR, $this->poa->getAttorneyApplicationAssertion());
        $this->poa->setAttorneyApplicationAssertion(PowerOfAttorney::PERMISSION_GIVEN_PLURAL);
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_PLURAL, $this->poa->getAttorneyApplicationAssertion());

        $this->poa->setAttorneyDeclarationSignatoryFullName($expectedSignatory);
        $this->poa->setAttorneyDeclarationSignatureDate($expectedDate);

        $this->assertEquals($expectedDate, $this->poa->getAttorneyDeclarationSignatureDate());
        $this->assertEquals($expectedSignatory, $this->poa->getAttorneyDeclarationSignatoryFullName());
    }

    public function testGetSetMentalHealthDeclarations()
    {
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_SINGULAR, $this->poa->getAttorneyMentalActPermission());
        $this->poa->setAttorneyMentalActPermission(PowerOfAttorney::PERMISSION_GIVEN_PLURAL);
        $this->assertEquals(PowerOfAttorney::PERMISSION_GIVEN_PLURAL, $this->poa->getAttorneyMentalActPermission());
    }

    public function testGetSetPayByCard()
    {
        $expectedCardDetails = 'Number 1234567890123456 \n Expiry 01/18\n CCV 123\n Name A Test Card User';

        $this->assertFalse($this->poa->getPaymentByDebitCreditCard());

        $this->poa
            ->setPaymentByDebitCreditCard(true)
            ->setCardPaymentContact($expectedCardDetails);

        $this->assertTrue($this->poa->getPaymentByDebitCreditCard());

        $this->assertEquals($expectedCardDetails, $this->poa->getCardPaymentContact());
    }

    public function testGetSetPayByCheque()
    {
        $this->assertFalse($this->poa->getPaymentByCheque());
        $this->poa->setPaymentByCheque(true);
        $this->assertTrue($this->poa->getPaymentByCheque());
        $this->poa->setPaymentByCheque();
        $this->assertFalse($this->poa->getPaymentByCheque());
    }

    public function testGetSetFeeExemption()
    {
        $this->assertFalse($this->poa->getFeeExemptionAppliedFor());
        $this->poa->setFeeExemptionAppliedFor(true);
        $this->assertTrue($this->poa->getFeeExemptionAppliedFor());
        $this->poa->setFeeExemptionAppliedFor();
        $this->assertFalse($this->poa->getFeeExemptionAppliedFor());
    }

    public function testGetSetFeeRemission()
    {
        $this->assertFalse($this->poa->getFeeRemissionAppliedFor());
        $this->poa->setFeeRemissionAppliedFor(true);
        $this->assertTrue($this->poa->getFeeRemissionAppliedFor());
        $this->poa->setFeeRemissionAppliedFor();
        $this->assertFalse($this->poa->getFeeRemissionAppliedFor());
    }
}
