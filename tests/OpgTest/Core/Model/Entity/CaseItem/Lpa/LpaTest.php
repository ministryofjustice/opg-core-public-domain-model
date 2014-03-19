<?php
namespace OpgTest\Core\Model\CaseItem\Lpa;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\Page\Page;

/**
 * Lpa test case.
 */
class LpaTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Lpa
     */
    private $lpa;

    protected function setUp()
    {
        parent::setUp();

        $this->lpa = new Lpa();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->lpa = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testGetSetId()
    {
        $Id = '1234567123';

        $this->lpa->setId($Id);

        $this->assertEquals(
            $Id,
            $this->lpa->getId()
        );
    }

    public function testGetsetTitle()
    {
        $title = 'this is a title';

        $this->lpa->setTitle($title);

        $this->assertEquals(
            $title,
            $this->lpa->getTitle()
        );
    }

    public function testGetSetDonor()
    {
        $donor = new Donor();
        $donor->setId(123);
        $this->lpa->setDonor($donor);

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor',
            $this->lpa->getDonor()
        );
    }

    public function testThrowsExceptionWhenTryingToPassBadObjectToSetDonor()
    {
        $donor = new Attorney();
        $donor->setId(123);
        $this->setExpectedException('Exception');
        $this->lpa->setDonor($donor);
    }

    public function testGetSetCorrespondent()
    {
        $correspondent = new Correspondent();
        $correspondent->setId(123);
        $this->lpa->setCorrespondent($correspondent);

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent',
            $this->lpa->getCorrespondent()
        );
    }

    public function testGetSetApplicantCollection()
    {
        $applicantCollection = new ArrayCollection();
        $this->lpa->setApplicants($applicantCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->lpa->getApplicants()
        );
    }

    public function testThrowsExceptionWhenTryingToPassBadObjectToSetCorrespondent()
    {
        $correspondent = new Attorney();
        $correspondent->setId(123);
        $this->setExpectedException('Exception');
        $this->lpa->setCorrespondent($correspondent);
    }

    public function testGetSetAttorneyCollection()
    {
        $attorneyCollection = new ArrayCollection();
        $this->lpa->setAttorneys($attorneyCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->lpa->getAttorneys()
        );
    }

    public function testGetSetNotifiedPersonCollection()
    {
        $notifiedPersonCollection = new ArrayCollection();
        $this->lpa->setNotifiedPersons($notifiedPersonCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->lpa->getNotifiedPersons()
        );
    }

    public function testGetSetCertificateProviderCollection()
    {
        $certificateProviderCollection = new ArrayCollection();
        $this->lpa->setCertificateProviders($certificateProviderCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->lpa->getCertificateProviders()
        );
    }

    public function testGetSetCardPaymentContact()
    {
        $expected = 'Mrs Henrietta Miggins';

        $this->lpa->setCardPaymentContact($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getCardPaymentContact()
        );
    }

    public function testGetSetRegistrationDueDate()
    {
        $expected = '2014-09-25';

        $this->lpa->setRegistrationDueDate($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getRegistrationDueDate()
        );
    }

    public function testGetSetHowAttorneysAct()
    {
        $expected = 'Jointly and Severally';

        $this->lpa->setHowAttorneysAct($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getHowAttorneysAct()
        );
    }

    public function testGetSetHowReplacementAttorneysAct()
    {
        $expected = 'Jointly';

        $this->lpa->setHowReplacementAttorneysAct($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getHowReplacementAttorneysAct()
        );
    }

    public function testGetSetAttorneyActDecisions()
    {
        $expected = 'These are some attorney decision instructions';

        $this->lpa->setAttorneyActDecisions($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getAttorneyActDecisions()
        );
    }

    public function testGetSetReplacementAttorneyActDecisions()
    {
        $expected = 'These are some replacement attorney decision instructions';

        $this->lpa->setReplacementAttorneyActDecisions($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getReplacementAttorneyActDecisions()
        );
    }

    public function testGetSetReplacementOrder()
    {
        $expected = 'This is how the replacements should replace the mains';

        $this->lpa->setReplacementOrder($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getReplacementOrder()
        );
    }

    public function testGetSetRestrictions()
    {
        $expected = "You can't do that";

        $this->lpa->setRestrictions($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getRestrictions()
        );
    }

    public function testGetSetGuidance()
    {
        $expected = "Please do this if possible";

        $this->lpa->setGuidance($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getGuidance()
        );
    }

    public function testGetSetCharges()
    {
        $expected = "Please pay all my attorneys 100 pounds a month";

        $this->lpa->setCharges($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getCharges()
        );
    }

    public function testGetSetAdditionalInfo()
    {
        $expected = "Here's something you might need to know";

        $this->lpa->setAdditionalInfo($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getAdditionalInfo()
        );
    }

    public function testGetSetPaymentId()
    {
        $expected = '123456/ABC';

        $this->lpa->setPaymentId($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getPaymentId()
        );
    }

    public function testGetSetPaymentAmount()
    {
        $expected = '130GBP';

        $this->lpa->setPaymentAmount($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getPaymentAmount()
        );
    }

    public function testGetSetPaymentDate()
    {
        $expected = '2014-07-27';

        $this->lpa->setPaymentDate($expected);

        $this->assertEquals(
            $expected,
            $this->lpa->getPaymentDate()
        );
    }

    public function testDonorValidation()
    {
        $this->assertFalse($this->lpa->isValid(['donor']));

        $this->lpa->setDonor(new Donor());
        $this->assertTrue($this->lpa->isValid(['donor']));
    }

    public function testHowAttorneysActValidation()
    {
        $this->assertTrue($this->lpa->isValid(['howAttorneysAct']));

        $this->lpa->setHowAttorneysAct('HOWEVER_THEY_LIKE');
        $this->assertFalse($this->lpa->isValid(['howAttorneysAct']));

        $this->lpa->setHowAttorneysAct('JOINTLY');
        $this->assertTrue($this->lpa->isValid(['howAttorneysAct']));

        $this->lpa->setHowAttorneysAct('SEVERALLY');
        $this->assertTrue($this->lpa->isValid(['howAttorneysAct']));

        $this->lpa->setHowAttorneysAct('JOINTLY_AND_SEVERALLY');
        $this->assertTrue($this->lpa->isValid(['howAttorneysAct']));
    }

    public function testHowReplacementAttorneysActValidation()
    {
        $this->assertTrue($this->lpa->isValid(['howReplacementAttorneysAct']));

        $this->lpa->setHowReplacementAttorneysAct('HOWEVER_THEY_LIKE');
        $this->assertFalse($this->lpa->isValid(['howReplacementAttorneysAct']));

        $this->lpa->setHowReplacementAttorneysAct('JOINTLY');
        $this->assertTrue($this->lpa->isValid(['howReplacementAttorneysAct']));

        $this->lpa->setHowReplacementAttorneysAct('SEVERALLY');
        $this->assertTrue($this->lpa->isValid(['howReplacementAttorneysAct']));

        $this->lpa->setHowReplacementAttorneysAct('JOINTLY_AND_SEVERALLY');
        $this->assertTrue($this->lpa->isValid(['howReplacementAttorneysAct']));
    }

    public function testValidationTraversalDownToValidApplicantCollection()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());

        $this->lpa->setApplicants($applicants);

        $this->assertTrue($this->lpa->isValid(['applicants']));
    }

    public function testValidationTraversalDownToInvalidApplicantCollection()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());
        $applicants->add(new Attorney());

        $this->lpa->setApplicants(  $applicants);

        $this->assertFalse($this->lpa->isValid(['applicants']));
    }

    public function testValidationInvalidPartyType()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());
        $applicants->add(new Attorney());
        $applicants->add(new Correspondent());

        $this->lpa->setApplicants(  $applicants);

        $this->assertFalse($this->lpa->isValid(['applicants']));
    }

    public function testGetInputFilter()
    {
        $inputFilter = $this->lpa->getInputFilter();

        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }

    public function testExchangeArray()
    {
        $data = array(
            'id' => '12345123'
        );

        $this->lpa->exchangeArray($data);

        $this->assertEquals(
            $data['id'],
            $this->lpa->getId()
        );
    }

    /**
     * @group array-recursive
     */
    public function testArrayRecursive()
    {
        $lpa = new Lpa();
        $lpa->setDonor(new Donor());
        $lpa->addApplicant(new Attorney());
        $lpa->addAttorney(new Attorney());
        $lpa->addCertificateProvider(new CertificateProvider());
        $lpa->addNotifiedPerson(new NotifiedPerson());
        $lpa->addDocument($doc = new Document());
        $doc->addPage(new Page());

        $this->assertEquals(
            array (
                'donor' => array (
                ),
                'correspondent' => NULL,
                'applicants' => array (
                ),
                'attorneys' => array (
                ),
                'notifiedPersons' => array (
                ),
                'certificateProviders' => array (
                ),
                'cardPaymentContact' => NULL,
                'registrationDueDate' => NULL,
                'howAttorneysAct' => NULL,
                'howReplacementAttorneysAct' => NULL,
                'attorneyActDecisions' => NULL,
                'replacementAttorneyActDecisions' => NULL,
                'replacementOrder' => NULL,
                'restrictions' => NULL,
                'guidance' => NULL,
                'charges' => NULL,
                'additionalInfo' => NULL,
                'paymentId' => NULL,
                'paymentAmount' => NULL,
                'paymentDate' => NULL,
                'id' => NULL,
                'title' => NULL,
                'caseType' => NULL,
                'caseSubtype' => NULL,
                'dueDate' => NULL,
                'status' => NULL,
                'assignedUser' => NULL,
                'tasks' => array (
                ),
                'notes' => array (
                ),
                'documents' => array (
                ),
                'caseItems' => array (
                ),
                'uId' => NULL,
                'inputFilter' => NULL,
                'errorMessages' => array (
                ),
                'taskStatus'    => array(),
                'lpaAccuracyAscertainedBy' => 1,
                'lpaDonorSignatureDate' => null,
                'lpaDonorSignatoryFullName' => null,
                'donorHasPreviousLpas' => false,
                'previousLpaInfo' => null,
                'lpaDonorDeclarationSignatureDate' => null,
                'lpaDonorDeclarationSignatoryFullName' => null,
                'usesNotifiedPersons' => false,
                'notifiedPersonPermissionBy' => 1,
                'attorneyPartyDeclaration' => 1,
                'attorneyApplicationAssertion' => 1,
                'attorneyMentalActPermission' => 1,
                'attorneyDeclarationSignatureDate' => null,
                'attorneyDeclarationSignatoryFullName' => null,
                'correspondentComplianceAssertion' => 1,
                'certificateProviders' => array (),
                'paymentByDebitCreditCard' => false,
                'paymentByCheque' => false,
                'feeExemptionAppliedFor' => false,
                'feeRemissionAppliedFor' => false,
                'caseAttorneySingular' => false,
                'caseAttorneyJointlyAndSeverally' => false,
                'caseAttorneyJointly' => false,
                'caseAttorneyJointlyAndJointlyAndSeverally' => false,
                'lpaCreatedDate'    => null,
                'lpaReceiptDate'   => null,
                'oldCaseId' => null,
                'applicationType' => 0,
                'registrationDate' => null,
                'closedDate' => null,
                'lifeSustainingTreatment' => false,
                'lifeSustainingTreatmentSignatureDate' => null,
            ),
            $lpa->toArrayRecursive()
        );
    }

    public function testAddPerson()
    {
        $donor = new Donor();
        $donor->setId('1');
        $this->lpa->addPerson($donor);
        $this->assertEquals($donor,$this->lpa->getDonor());

        $attorney = new Attorney();
        $attorney->setId('1');
        $this->lpa->addPerson($attorney);
        $this->assertEquals($attorney,$this->lpa->getAttorneys()[0]);

        $certificateProvider = new CertificateProvider();
        $certificateProvider->setId('1');
        $this->lpa->addPerson($certificateProvider);
        $this->assertEquals($certificateProvider,$this->lpa->getCertificateProviders()[0]);

        $notifiedPerson = new NotifiedPerson();
        $notifiedPerson->setId('1');
        $this->lpa->addPerson($notifiedPerson);
        $this->assertEquals($notifiedPerson,$this->lpa->getNotifiedPersons()[0]);

        $correspondent = new Correspondent();
        $correspondent->setId('1');
        $this->lpa->addPerson($correspondent);
        $this->assertEquals($correspondent,$this->lpa->getCorrespondent());

        $person = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Person\Person');
        $person->setId('1');

        try {
            $this->lpa->addPerson($person);
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

    public function testGetSetDonorDeclarations()
    {
        $expectedDate = new \DateTime();
        $expectedDonorFullName = 'Mr Test Donor';

        $this->lpa->setDonorDeclarationSignatureDate($expectedDate);
        $this->lpa->setDonorDeclarationLpaSignatoryFullName($expectedDonorFullName);

        $this->assertEquals($expectedDate, $this->lpa->getDonorDeclarationSignatureDate());
        $this->assertEquals($expectedDonorFullName, $this->lpa->getDonorDeclarationLpaSignatoryFullName());
    }

    public function testGetSetDonorSignature()
    {
        $expectedDate = new \DateTime();
        $expectedDonorFullName = 'Mr Test Donor';

        $this->lpa->setDonorSignatureDate($expectedDate);
        $this->lpa->setDonorLpaSignatoryFullName($expectedDonorFullName);

        $this->assertEquals($expectedDate, $this->lpa->getDonorSignatureDate());
        $this->assertEquals($expectedDonorFullName, $this->lpa->getDonorLpaSignatoryFullName());
    }

    public function testGetSetPreviousLpa()
    {
        $expectedPreviousLpas = true;
        $expectedLpaInfo =  "Bacon ipsum dolor sit amet short ribs pork chop short loin ham hock est.";

        $this->assertFalse($this->lpa->hasPreviousLpas());

        $this->lpa->setDonorHasPreviousLpas($expectedPreviousLpas);
        $this->lpa->setPreviousLpaInfo($expectedLpaInfo);

        $this->assertTrue($this->lpa->hasPreviousLpas());
        $this->assertEquals($expectedLpaInfo, $this->lpa->getPreviousLpaInfo());
    }

    public function testGetSetAccuracyAscertainedBy()
    {
        $this->assertEquals(Lpa::PERMISSION_GIVEN_SINGULAR, $this->lpa->getAccuracyAscertainedBy());

        $this->lpa->setAccuracyAscertainedBy(LPA::PERMISSION_GIVEN_PLURAL);
        $this->assertEquals(Lpa::PERMISSION_GIVEN_PLURAL, $this->lpa->getAccuracyAscertainedBy());
    }

    public function testGetSetLpaCreatedDate()
    {
        $expectedDate = new \DateTime();
        $this->assertNull($this->lpa->getLpaCreatedDate());
        $this->lpa->setLpaCreatedDate($expectedDate);
        $this->assertEquals($expectedDate, $this->lpa->getLpaCreatedDate());

    }

    public function testGetSetLpaReceiptDate()
    {
        $expectedDate = new \DateTime();
        $this->assertNull($this->lpa->getLpaReceiptDate());
        $this->lpa->setLpaReceiptDate($expectedDate);
        $this->assertEquals($expectedDate, $this->lpa->getLpaReceiptDate());
    }

    public function testGetSetLifeSustainingTreatment()
    {
        $lstDate = new \DateTime();

        $this->assertNull($this->lpa->getLifeSustainingTreatmentSignatureDate());
        $this->assertFalse($this->lpa->hasLifeSustainingTreatment());

        $this->lpa->setLifeSustainingTreatment(true)->setLifeSustainingTreatmentSignatureDate($lstDate);

        $this->assertEquals($lstDate, $this->lpa->getLifeSustainingTreatmentSignatureDate());
        $this->assertTrue($this->lpa->hasLifeSustainingTreatment());
    }
}
