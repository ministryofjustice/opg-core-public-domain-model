<?php
namespace OpgTest\Core\Model\CaseItem\Epa;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Epa\Epa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\Page\Page;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\CaseItem\Task\Task;

/**
 * Epa test case.
 */
class EpaTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Epa
     */
    private $epa;

    protected function setUp()
    {
        parent::setUp();

        $this->epa = new Epa();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->epa = null;

        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testGetAndSetId()
    {
        $Id = '1234567123';

        $this->epa->setId($Id);

        $this->assertEquals(
            $Id,
            $this->epa->getId()
        );
    }

    public function testGetAndSetTitle()
    {
        $title = 'this is a title';

        $this->epa->setTitle($title);

        $this->assertEquals(
            $title,
            $this->epa->getTitle()
        );
    }

    public function testGetAndSetDonor()
    {
        $donor = new Donor();
        $donor->setId(123);
        $this->epa->setDonor($donor);

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor',
            $this->epa->getDonor()
        );
    }

    public function testThrowsExceptionWhenTryingToPassBadObjectToSetDonor()
    {
        $donor = new Attorney();
        $donor->setId(123);
        $this->setExpectedException('Exception');
        $this->epa->setDonor($donor);
    }

    public function testGetSetCorrespondent()
    {
        $correspondent = new Correspondent();
        $correspondent->setId(123);
        $this->epa->setCorrespondent($correspondent);

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent',
            $this->epa->getCorrespondent()
        );
    }

    public function testGetSetApplicantCollection()
    {
        $applicantCollection = new ArrayCollection();
        $this->epa->setApplicants($applicantCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->epa->getApplicants()
        );
    }

    public function testThrowsExceptionWhenTryingToPassBadObjectToSetCorrespondent()
    {
        $correspondent = new Attorney();
        $correspondent->setId(123);
        $this->setExpectedException('Exception');
        $this->epa->setCorrespondent($correspondent);
    }

    public function testGetSetAttorneyCollection()
    {
        $attorneyCollection = new ArrayCollection();
        $this->epa->setAttorneys($attorneyCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->epa->getAttorneys()
        );
    }

    public function testGetSetNotifiedPersonCollection()
    {
        $notifiedPersonCollection = new ArrayCollection();
        $this->epa->setNotifiedPersons($notifiedPersonCollection);

        $this->assertInstanceOf(
            'Doctrine\Common\Collections\ArrayCollection',
            $this->epa->getNotifiedPersons()
        );
    }

    public function testGetSetHowAttorneysAct()
    {
        $expected = 'Jointly and Severally';

        $this->epa->setHowAttorneysAct($expected);

        $this->assertEquals(
            $expected,
            $this->epa->getHowAttorneysAct()
        );
    }

    public function testValidationTraversalDownToValidApplicantCollection()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());

        $this->epa->setApplicants($applicants);

        $this->assertTrue($this->epa->isValid(['applicants']));
    }

    public function testValidationTraversalDownToInvalidApplicantCollection()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());
        $applicants->add(new Attorney());

        $this->epa->setApplicants($applicants);

        $this->assertFalse($this->epa->isValid(['applicants']));
    }

    public function testValidationInvalidPartyType()
    {
        $applicants = new ArrayCollection();
        $applicants->add(new Donor());
        $applicants->add(new Attorney());
        $applicants->add(new Correspondent());

        $this->epa->setApplicants($applicants);

        $this->assertFalse($this->epa->isValid(['applicants']));
    }

    /**
     * @group array-recursive
     */
//    public function testArrayRecursive()
//    {
//        $epa = new Epa();
//        $epa->setDonor(new Donor());
//        $epa->addApplicant(new Attorney());
//        $epa->addAttorney(new Attorney());
//        $epa->addNotifiedPerson(new NotifiedPerson());
//        $epa->addDocument($doc = new Document());
//        $doc->addPage(new Page());
//
//        $this->assertEquals(
//            array(
//                'donor'                                     => array(),
//                'correspondent'                             => null,
//                'applicants'                                => array(),
//                'attorneys'                                 => array(),
//                'notifiedPersons'                           => array(),
//                'id'                                        => null,
//                'title'                                     => null,
//                'caseType'                                  => 'epa',
//                'caseSubtype'                               => null,
//                'dueDate'                                   => null,
//                'status'                                    => null,
//                'assignee'                                  => null,
//                'tasks'                                     => array(),
//                'notes'                                     => array(),
//                'documents'                                 => array(),
//                'caseItems'                                 => array(),
//                'uId'                                       => null,
//                'inputFilter'                               => null,
//                'errorMessages'                             => array(),
//                'taskStatus'                                => array(),
//                'EpaDonorSignatureDate'                     => null,
//                'donorHasPreviousLpas'                      => false,
//                'previousLpaInfo'                           => null,
//                'usesNotifiedPersons'                       => false,
//                'notifiedPersonPermissionBy'                => 1,
//                'attorneyPartyDeclaration'                  => 1,
//                'attorneyApplicationAssertion'              => 1,
//                'attorneyMentalActPermission'               => 1,
//                'attorneyDeclarationSignatureDate'          => null,
//                'correspondentComplianceAssertion'          => 1,
//                'certificateProviders'                      => array(),
//                'paymentByDebitCreditCard'                  => 0,
//                'paymentByCheque'                           => 0,
//                'feeExemptionAppliedFor'                    => 0,
//                'feeRemissionAppliedFor'                    => 0,
//                'caseAttorneySingular'                      => false,
//                'caseAttorneyJointlyAndSeverally'           => false,
//                'caseAttorneyJointly'                       => false,
//                'caseAttorneyJointlyAndJointlyAndSeverally' => false,
//                'lpaCreatedDate'                            => null,
//                'lpaReceiptDate'                            => null,
//                'oldCaseId'                                 => null,
//                'applicationType'                           => 0,
//                'registrationDate'                          => null,
//                'closedDate'                                => null,
//                'lifeSustainingTreatment'                   => null,
//                'lifeSustainingTreatmentSignatureDate'      => null,
//                'notificationDate'                          => null,
//                'dispatchDate'                              => null,
//                'noticeGivenDate'                           => null,
//                'correspondence'                            => null,
//                'ragRating'                                 => null,
//                'ragTotal'                                  => null,
//                'paymentRemission'                          => 0,
//                'paymentExemption'                          => 0,
//                'trustCorporationSignedAs'                  => null,
//                'noNoticeGiven'                             => false,
//                'businessRules'                             => array(),
//                'normalizedUid'                             => null,
//                'rejectedDate'                              => null,
//                'applicantType'                             => null,
//                'cancellationDate'                          => null
//            ),
//            $epa->toArrayRecursive()
//        );
//    }

    public function testAddPerson()
    {
        $donor = new Donor();
        $donor->setId('1');
        $this->epa->addPerson($donor);
        $this->assertEquals($donor, $this->epa->getDonor());

        $attorney = new Attorney();
        $attorney->setId('1');
        $this->epa->addPerson($attorney);
        $this->assertEquals($attorney, $this->epa->getAttorneys()[0]);

        $notifiedPerson = new NotifiedPerson();
        $notifiedPerson->setId('1');
        $this->epa->addPerson($notifiedPerson);
        $this->assertEquals($notifiedPerson, $this->epa->getNotifiedPersons()[0]);

        $correspondent = new Correspondent();
        $correspondent->setId('1');
        $this->epa->addPerson($correspondent);
        $this->assertEquals($correspondent, $this->epa->getCorrespondent());

        $person = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Person\Person');
        $person->setId('1');

        try {
            $this->epa->addPerson($person);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

    public function testGetSetDonorSignature()
    {
        $expectedDate          = new \DateTime();
        $expectedDonorFullName = 'Mr Test Donor';

        $this->epa->setEpaDonorSignatureDate($expectedDate);

        $this->assertEquals($expectedDate, $this->epa->getEpaDonorSignatureDate());

    }

    public function testGetSetEpaDonorSignatureDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->epa->getEpaDonorSignatureDate());
        $this->epa->setEpaDonorSignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->epa->getEpaDonorSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetEpaDonorSignatureDateEmptyString()
    {
        $this->assertEmpty($this->epa->getEpaDonorSignatureDateString());
        $this->epa->setEpaDonorSignatureDateString('');

        $this->assertEmpty($this->epa->getEpaDonorSignatureDateString());
    }

    public function testGetSetEpaDonorSignatureDateString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->epa->getEpaDonorSignatureDateString());
        $this->epa->setEpaDonorSignatureDateString($expected);

        $this->assertEquals($expected, $this->epa->getEpaDonorSignatureDateString());
    }

    public function testGetSetPreviousEpa()
    {
        $expectedOtherEpas = true;
        $expectedEpaInfo      = "Bacon ipsum dolor sit amet short ribs pork chop short loin ham hock est.";

        $this->assertFalse($this->epa->hasOtherEpas());

        $this->epa->setDonorHasOtherEpas($expectedOtherEpas);
        $this->epa->setOtherEpaInfo($expectedEpaInfo);

        $this->assertTrue($this->epa->hasOtherEpas());
        $this->assertEquals($expectedEpaInfo, $this->epa->getOtherEpaInfo());
    }

    public function testConstantsExist()
    {
        $class = "Opg\Core\Model\Entity\CaseItem\Lpa\Lpa";
        $this->assertEquals($class::HW_FULLTEXTNAME, "Health and Welfare");
        $this->assertEquals($class::PF_FULLTEXTNAME, "Property and Financial Affairs");
    }

    public function testGetRagRatingRed()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y', strtotime('Last Week')));

        $this->epa->addTask($task);
        $this->epa->addTask($task);

        $this->assertEquals(3, $this->epa->getRagRating());
        $this->assertEquals(6, $this->epa->getRagTotal());
    }

    public function testGetRagRatingAmber()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y'));

        $this->epa->addTask($task);
        $this->epa->addTask($task);

        $this->assertEquals(2, $this->epa->getRagRating());
        $this->assertEquals(4, $this->epa->getRagTotal());
    }

    public function testGetRagRatingGreen()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y', strtotime('Next Week')));

        $this->epa->addTask($task);
        $this->epa->addTask($task);

        $this->assertEquals(1, $this->epa->getRagRating());
        $this->assertEquals(2, $this->epa->getRagTotal());
    }

    public function testFilterTasks()
    {
        $task = new Task();
        $task->setDueDateString(date('d/m/Y', strtotime('next week')));
        $this->epa->addTask($task);

        $task2 = new Task();
        $task2->setActiveDateString(date('d/m/Y', strtotime('tomorrow')));
        $this->epa->addTask($task2);

        $task3 = new Task();
        $task3->setActiveDateString(date('d/m/Y', strtotime('yesterday')));
        $this->epa->addTask($task3);


        $this->assertEquals(2, count($this->epa->filterTasks()));
    }

//    public function testUIDValidatorFailsInvalidChecksum()
//    {
//        $uid = '12345';
//
//        $this->epa->setUid($uid);
//
//        $this->assertFalse($this->epa->isValid(array('uId')));
//
//        $this->assertCount(2, $this->epa->getErrorMessages()['errors']['uId']);
//
//        $this->assertEquals(
//            "The uid '12345' is not in the expected format",
//            $this->epa->getErrorMessages()['errors']['uId']['incorrectFormat']
//        );
//
//        $this->assertEquals(
//            "The uid '12345' did not validate against its checksum.",
//            $this->epa->getErrorMessages()['errors']['uId']['invalidChecksum']
//        );
//    }

    public function testUIDValidatorPassesInvalidChecksum()
    {
        $uid = '700000011440';

        $this->epa->setUid($uid);

        $this->assertTrue($this->epa->isValid(array('uId')));

        $this->assertEmpty($this->epa->getErrorMessages()['errors']);

    }

//    public function testIdOutOfRangeFails()
//    {
//        $id = PHP_INT_MAX;
//
//        $this->epa->setId($id);
//
//        $this->assertFalse($this->epa->isValid(array('id')));
//
//        $this->assertEquals(
//            "'9223372036854775807' exceeds the maximum integer range allowed.",
//            $this->epa->getErrorMessages()['errors']['id']['outOfRange']
//        );
//    }

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

        $this->assertEmpty($this->epa->getApplicantType());
        $this->epa->setApplicantType($expected);

        $this->assertEquals($expected, $this->epa->getApplicantType());
    }
}
