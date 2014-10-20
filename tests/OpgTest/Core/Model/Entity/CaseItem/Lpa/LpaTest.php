<?php
namespace OpgTest\Core\Model\CaseItem\Lpa;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseItem\Page\Page;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseActor\Attorney;
use Opg\Core\Model\Entity\CaseActor\CertificateProvider;
use Opg\Core\Model\Entity\CaseActor\Correspondent;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;
use Opg\Core\Model\Entity\Document\IncomingDocument;

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
            'Opg\Core\Model\Entity\CaseActor\Donor',
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
            'Opg\Core\Model\Entity\CaseActor\Correspondent',
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

        $this->lpa->setApplicants($applicants);

        $this->assertFalse($this->lpa->isValid(['applicants']));
    }

    public function testValidationInvalidPartyType()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());
        $applicants->add(new Attorney());
        $applicants->add(new Correspondent());

        $this->lpa->setApplicants($applicants);

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
        $lpa->addDocument($doc = new IncomingDocument());
        $doc->addPage(new Page());

        $this->assertEquals(
            array(
                'donor'                                     => array(),
                'correspondent'                             => null,
                'applicants'                                => array(),
                'attorneys'                                 => array(),
                'notifiedPersons'                           => array(),
                'certificateProviders'                      => array(),
                'cardPaymentContact'                        => null,
                'howAttorneysAct'                           => null,
                'howReplacementAttorneysAct'                => null,
                'attorneyActDecisions'                      => null,
                'replacementAttorneyActDecisions'           => null,
                'replacementOrder'                          => null,
                'restrictions'                              => null,
                'guidance'                                  => null,
                'charges'                                   => null,
                'additionalInfo'                            => null,
                'paymentId'                                 => null,
                'paymentAmount'                             => null,
                'paymentDate'                               => null,
                'id'                                        => null,
                'title'                                     => null,
                'caseType'                                  => 'lpa',
                'caseSubtype'                               => null,
                'dueDate'                                   => null,
                'status'                                    => null,
                'assignee'                                  => null,
                'tasks'                                     => array(),
                'notes'                                     => array(),
                'caseItems'                                 => array(),
                'uId'                                       => null,
                'inputFilter'                               => null,
                'errorMessages'                             => array(),
                'taskStatus'                                => array(),
                'lpaAccuracyAscertainedBy'                  => 1,
                'lpaDonorSignatureDate'                     => null,
                'lpaDonorSignatoryFullName'                 => null,
                'donorHasPreviousLpas'                      => false,
                'previousLpaInfo'                           => null,
                'lpaDonorDeclarationSignatureDate'          => null,
                'lpaDonorDeclarationSignatoryFullName'      => null,
                'usesNotifiedPersons'                       => false,
                'notifiedPersonPermissionBy'                => 1,
                'attorneyPartyDeclaration'                  => 1,
                'attorneyApplicationAssertion'              => 1,
                'attorneyMentalActPermission'               => 1,
                'attorneyDeclarationSignatureDate'          => null,
                'attorneyDeclarationSignatoryFullName'      => null,
                'correspondentComplianceAssertion'          => 1,
                'certificateProviders'                      => array(),
                'paymentByDebitCreditCard'                  => 0,
                'paymentByCheque'                           => 0,
                'wouldLikeToApplyForFeeRemission'           => 0,
                'haveAppliedForFeeRemission'                => 0,
                'caseAttorneySingular'                      => false,
                'caseAttorneyJointlyAndSeverally'           => false,
                'caseAttorneyJointly'                       => false,
                'caseAttorneyJointlyAndJointlyAndSeverally' => false,
                'lpaCreatedDate'                            => null,
                'lpaReceiptDate'                            => null,
                'oldCaseId'                                 => null,
                'applicationType'                           => 0,
                'registrationDate'                          => null,
                'closedDate'                                => null,
                'lifeSustainingTreatment'                   => null,
                'lifeSustainingTreatmentSignatureDateA'     => null,
                'lifeSustainingTreatmentSignatureDateB'     => null,
                'notificationDate'                          => null,
                'dispatchDate'                              => null,
                'noticeGivenDate'                           => null,
                'documents'                                 => array(),
                'ragRating'                                 => null,
                'ragTotal'                                  => null,
                'paymentRemission'                          => 0,
                'paymentExemption'                          => 0,
                'trustCorporationSignedAs'                  => null,
                'noNoticeGiven'                             => false,
                'businessRules'                             => array(),
                'normalizedUid'                             => null,
                'rejectedDate'                              => null,
                'applicantType'                             => null,
                'cancellationDate'                          => null,
                'payments'                                  => array(),
            ),
            $lpa->toArrayRecursive()
        );
    }

    public function testAddPerson()
    {
        $donor = new Donor();
        $donor->setId('1');
        $this->lpa->addPerson($donor);
        $this->assertEquals($donor, $this->lpa->getDonor());

        $attorney = new Attorney();
        $attorney->setId('1');
        $this->lpa->addPerson($attorney);
        $this->assertEquals($attorney, $this->lpa->getAttorneys()[0]);

        $certificateProvider = new CertificateProvider();
        $certificateProvider->setId('1');
        $this->lpa->addPerson($certificateProvider);
        $this->assertEquals($certificateProvider, $this->lpa->getCertificateProviders()[0]);

        $notifiedPerson = new NotifiedPerson();
        $notifiedPerson->setId('1');
        $this->lpa->addPerson($notifiedPerson);
        $this->assertEquals($notifiedPerson, $this->lpa->getNotifiedPersons()[0]);

        $correspondent = new Correspondent();
        $correspondent->setId('1');
        $this->lpa->addPerson($correspondent);
        $this->assertEquals($correspondent, $this->lpa->getCorrespondent());

        $person = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Person\Person');
        $person->setId('1');

        try {
            $this->lpa->addPerson($person);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

    public function testGetSetDonorDeclarations()
    {
        $expectedDate          = new \DateTime();
        $expectedDonorFullName = 'Mr Test Donor';

        $this->lpa->setDonorDeclarationSignatureDate($expectedDate);
        $this->lpa->setDonorDeclarationLpaSignatoryFullName($expectedDonorFullName);

        $this->assertEquals($expectedDate, $this->lpa->getDonorDeclarationSignatureDate());
        $this->assertEquals($expectedDonorFullName, $this->lpa->getDonorDeclarationLpaSignatoryFullName());
    }

    public function testGetSetSetDonorDeclarationDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getDonorDeclarationSignatureDate());
        $this->lpa->setDonorDeclarationSignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->lpa->getDonorDeclarationSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetSetDonorDeclarationDateEmptyString()
    {
        $this->assertEmpty($this->lpa->getDonorDeclarationSignatureDateString());
        $this->lpa->setDonorDeclarationSignatureDateString('');

        $this->assertEmpty($this->lpa->getDonorDeclarationSignatureDateString());

    }

    public function testGetSetSetDonorDeclarationDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->lpa->getDonorDeclarationSignatureDateString());
        $this->lpa->setDonorDeclarationSignatureDateString($expected);

        $this->assertEquals($expected, $this->lpa->getDonorDeclarationSignatureDateString());
    }

    public function testGetSetDonorSignature()
    {
        $expectedDate          = new \DateTime();
        $expectedDonorFullName = 'Mr Test Donor';

        $this->lpa->setLpaDonorSignatureDate($expectedDate);
        $this->lpa->setDonorLpaSignatoryFullName($expectedDonorFullName);

        $this->assertEquals($expectedDate, $this->lpa->getLpaDonorSignatureDate());
        $this->assertEquals($expectedDonorFullName, $this->lpa->getDonorLpaSignatoryFullName());

    }

    public function testGetSetLpaDonorSignatureDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getLpaDonorSignatureDate());
        $this->lpa->setLpaDonorSignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->lpa->getLpaDonorSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpaDonorSignatureDateEmptyString()
    {
        $this->assertEmpty($this->lpa->getLpaDonorSignatureDateString());
        $this->lpa->setLpaDonorSignatureDateString('');

        $this->assertEmpty($this->lpa->getLpaDonorSignatureDateString());
    }

    public function testGetSetLpaDonorSignatureDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->lpa->getLpaDonorSignatureDateString());
        $this->lpa->setLpaDonorSignatureDateString($expected);

        $this->assertEquals($expected, $this->lpa->getLpaDonorSignatureDateString());
    }

    public function testGetSetPreviousLpa()
    {
        $expectedPreviousLpas = true;
        $expectedLpaInfo      = "Bacon ipsum dolor sit amet short ribs pork chop short loin ham hock est.";

        $this->assertFalse($this->lpa->hasPreviousLpas());

        $this->lpa->setDonorHasPreviousLpas($expectedPreviousLpas);
        $this->lpa->setPreviousLpaInfo($expectedLpaInfo);

        $this->assertTrue($this->lpa->hasPreviousLpas());
        $this->assertEquals($expectedLpaInfo, $this->lpa->getPreviousLpaInfo());
    }

    public function testGetSetLpaAccuracyAscertainedBy()
    {
        $this->assertEquals('I', $this->lpa->getLpaAccuracyAscertainedBy());

        $this->lpa->setLpaAccuracyAscertainedBy('We');
        $this->assertEquals('We', $this->lpa->getLpaAccuracyAscertainedBy());
    }

    public function testGetSetLpaCreatedDate()
    {
        $expectedDate = new \DateTime();
        $this->assertNull($this->lpa->getLpaCreatedDate());

        $this->lpa->setLpaCreatedDate($expectedDate);
        $this->assertEquals($expectedDate, $this->lpa->getLpaCreatedDate());

    }

    public function testGetSetLpaCreatedDateNulls()
    {
        $expectedDate = new \DateTime();
        $this->assertEmpty($this->lpa->getLpaCreatedDate());
        $this->lpa->setLpaCreatedDate();
        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->lpa->getLpaCreatedDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpaCreatedDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->lpa->getLpaCreatedDateString());
        $this->lpa->setLpaCreatedDateString($expected);
        $this->assertEquals($expected, $this->lpa->getLpaCreatedDateString());
    }


    public function testGetSetLpaCreatedDateEmptyString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getLpaCreatedDateString());
        $this->lpa->setLpaCreatedDateString(null);

        $returnedDate = $this->lpa->getLpaCreatedDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateTimeFormat()),
            $returnedDate->format(OPGDateFormat::getDateTimeFormat())
        );
    }

    public function testGetSetLpaReceiptDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getLpaReceiptDate());
        $this->assertEmpty($this->lpa->getLpaReceiptDateString());

        $this->lpa->setLpaReceiptDate($expectedDate);
        $this->assertEquals($expectedDate, $this->lpa->getLpaReceiptDate());
    }

    public function testGetSetLpaReceiptDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getLpaReceiptDate());
        $this->lpa->setLpaReceiptDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->lpa->getLpaReceiptDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpaReceiptDateEmptyString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getLpaReceiptDateString());
        $this->lpa->setLpaReceiptDateString('');

        $returnedDate = $this->lpa->getLpaReceiptDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpaReceiptDateString()
    {
        $expectedDate = date(OPGDateFormat::getDateTimeFormat());

        $this->assertEmpty($this->lpa->getLpaReceiptDateString());
        $this->lpa->setLpaReceiptDateString($expectedDate);

        $this->assertEquals($expectedDate, $this->lpa->getLpaReceiptDateString());
    }

    public function testGetSetLifeSustainingTreatment()
    {
        $lstDate = new \DateTime();
        $lstType = 'Option A';

        $this->assertNull($this->lpa->getLifeSustainingTreatmentSignatureDateA());
        $this->assertEmpty($this->lpa->hasLifeSustainingTreatment());

        $this->lpa->setLifeSustainingTreatment($lstType);
        $this->lpa->setLifeSustainingTreatmentSignatureDateA($lstDate);

        $this->assertEquals($lstDate, $this->lpa->getLifeSustainingTreatmentSignatureDateA());
        $this->assertTrue($this->lpa->hasLifeSustainingTreatment());
        $this->assertEquals($lstType, $this->lpa->getLifeSustainingTreatment());

    }

    public function testGetSetLifeSustainingTreatmentDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateA());
        $this->lpa->setLifeSustainingTreatmentSignatureDateA();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->lpa->getLifeSustainingTreatmentSignatureDateA()->format(OPGDateFormat::getDateFormat())
        );

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateB());
        $this->lpa->setLifeSustainingTreatmentSignatureDateB();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->lpa->getLifeSustainingTreatmentSignatureDateB()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLifeSustainingTreatmentDateEmptyString()
    {
        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateAString());
        $this->lpa->setLifeSustainingTreatmentSignatureDateAString('');

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateAString());

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateBString());
        $this->lpa->setLifeSustainingTreatmentSignatureDateBString('');

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateBString());
    }

    public function testGetSetLifeSustainingTreatmentDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateAString());
        $this->lpa->setLifeSustainingTreatmentSignatureDateAString($expected);

        $this->assertEquals($expected, $this->lpa->getLifeSustainingTreatmentSignatureDateAString());

        $this->assertEmpty($this->lpa->getLifeSustainingTreatmentSignatureDateBString());
        $this->lpa->setLifeSustainingTreatmentSignatureDateBString($expected);

        $this->assertEquals($expected, $this->lpa->getLifeSustainingTreatmentSignatureDateBString());
    }



    public function testValidatorInvalidNoCaseType()
    {
        // By default a new Lpa should have a caseType of 'lpa', which is valid.
        $this->assertTrue($this->lpa->isValid(['caseType']));
    }

    public function testValidatorValidDefaultCaseType()
    {
        $this->lpa->setCaseType(null);

        $this->assertFalse($this->lpa->isValid(['caseType']));
    }

    public function testValidatorInvalidNonExistentCaseType()
    {
        $this->lpa->setCaseType('NOT_A_REAL_CASE_TYPE');

        $this->assertFalse($this->lpa->isValid(['caseType']));
    }

    public function testValidatorInvalidNoCaseSubtype()
    {
        $this->lpa->setCaseSubtype(null);

        $this->assertFalse($this->lpa->isValid(['caseSubtype']));
    }

    public function testValidatorInvalidNonExistentCaseSubtype()
    {
        $this->lpa->setCaseType('NOT_A_REAL_CASE_TYPE');

        $this->assertFalse($this->lpa->isValid(['caseSubtype']));
    }

    public function testConstantsExist()
    {
        $class = "Opg\Core\Model\Entity\CaseItem\Lpa\Lpa";
        $this->assertEquals($class::HW_FULLTEXTNAME, "Health and Welfare");
        $this->assertEquals($class::PF_FULLTEXTNAME, "Property and Financial Affairs");
    }

    public function testGetSetTrustCorporationSignedAs()
    {
        $expected = 'I';

        $this->assertEquals('We', $this->lpa->getTrustCorporationSignedAs());
        $this->lpa->setTrustCorporationSignedAs($expected);

        $this->assertEquals($expected, $this->lpa->getTrustCorporationSignedAs());

        $this->lpa->setTrustCorporationSignedAs('We');

        $this->assertNotEquals($expected, $this->lpa->getTrustCorporationSignedAs());
    }

    public function testGetRagRatingRed()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y', strtotime('Last Week')));

        $this->lpa->addTask($task);
        $this->lpa->addTask($task);

        $this->assertEquals(3, $this->lpa->getRagRating());
        $this->assertEquals(6, $this->lpa->getRagTotal());
    }

    public function testGetRagRatingAmber()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y'));

        $this->lpa->addTask($task);
        $this->lpa->addTask($task);

        $this->assertEquals(2, $this->lpa->getRagRating());
        $this->assertEquals(4, $this->lpa->getRagTotal());
    }

    public function testGetRagRatingGreen()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y', strtotime('Next Week')));

        $this->lpa->addTask($task);
        $this->lpa->addTask($task);

        $this->assertEquals(1, $this->lpa->getRagRating());
        $this->assertEquals(2, $this->lpa->getRagTotal());
    }

    public function testFilterTasks()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y', strtotime('next week')));
        $this->lpa->addTask($task);

        $task2 = new Task();
        $task2->setActiveDateString(date('d/m/Y', strtotime('tomorrow')));
        $this->lpa->addTask($task2);

        $task3 = new Task();
        $task3->setActiveDateString(date('d/m/Y', strtotime('yesterday')));
        $this->lpa->addTask($task3);


        $this->assertEquals(2, count($this->lpa->filterTasks()));
    }

    public function testUIDValidatorFailsInvalidChecksum()
    {
        $uid = '12345';

        $this->lpa->setUid($uid);

        $this->assertFalse($this->lpa->isValid(array('uId')));

        $this->assertCount(2, $this->lpa->getErrorMessages()['errors']['uId']);

        $this->assertEquals(
            "The uid '12345' is not in the expected format",
            $this->lpa->getErrorMessages()['errors']['uId']['incorrectFormat']
        );

        $this->assertEquals(
            "The uid '12345' did not validate against its checksum.",
            $this->lpa->getErrorMessages()['errors']['uId']['invalidChecksum']
        );
    }

    public function testUIDValidatorPassesInvalidChecksum()
    {
        $uid = '700000011440';

        $this->lpa->setUid($uid);

        $this->assertTrue($this->lpa->isValid(array('uId')));

        $this->assertEmpty($this->lpa->getErrorMessages()['errors']);

    }

    public function testIdOutOfRangeFails()
    {
        $id = PHP_INT_MAX;

        $this->lpa->setId($id);

        $this->assertFalse($this->lpa->isValid(array('id')));

        $this->assertEquals(
            "'9223372036854775807' exceeds the maximum integer range allowed.",
            $this->lpa->getErrorMessages()['errors']['id']['outOfRange']
        );
    }

    public function testAttorneyCollectionCreatedIfNullWhenAddAttorneyCalled()
    {
        /*
         * If the constuctor is not called, some collections will not get initialised
         * Here we confirm that this does not break the addAttorney method
         */

        $lpa = unserialize(
            sprintf(
                'O:%d:"%s":0:{}',
                strlen('Opg\Core\Model\Entity\CaseItem\Lpa\Lpa'),
                'Opg\Core\Model\Entity\CaseItem\Lpa\Lpa'
            )
        );

        $attorney = new Attorney();

        $lpa->addAttorney($attorney);

        $this->assertEquals(
            1,
            $lpa->getAttorneys()->count()
        );
    }

    public function testGetAttorneyCollectionCreateIfNullWhenGetAttorneysCalled()
    {
        /*
         * If the constuctor is not called, some collections will not get initialised
         * Here we confirm that this does not break the addAttorney method
         */

        $lpa = unserialize(
            sprintf(
                'O:%d:"%s":0:{}',
                strlen('Opg\Core\Model\Entity\CaseItem\Lpa\Lpa'),
                'Opg\Core\Model\Entity\CaseItem\Lpa\Lpa'
            )
        );

        $this->assertCount(0, $lpa->getAttorneys()->toArray());
    }

    public function testGetSetApplicantType()
    {
        $expected = 'Test Type';

        $this->assertEmpty($this->lpa->getApplicantType());
        $this->lpa->setApplicantType($expected);

        $this->assertEquals($expected, $this->lpa->getApplicantType());
    }
}
