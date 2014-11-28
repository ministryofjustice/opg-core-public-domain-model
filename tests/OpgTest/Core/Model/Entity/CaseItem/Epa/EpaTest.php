<?php
namespace OpgTest\Core\Model\CaseItem\Epa;

use Opg\Core\Model\Entity\CaseActor\PersonNotifyDonor;

use Opg\Core\Model\Entity\CaseActor\NotifiedAttorney;

use Opg\Core\Model\Entity\CaseActor\NotifiedRelative;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Epa\Epa;
use Opg\Core\Model\Entity\Document\Page\Page;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\Task\Task;
use Opg\Core\Model\Entity\CaseActor\Attorney;
use Opg\Core\Model\Entity\CaseActor\Correspondent;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\Document\IncomingDocument;

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

        $this->epa = new EpaStub();
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
            'Opg\Core\Model\Entity\CaseActor\Donor',
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
            'Opg\Core\Model\Entity\CaseActor\Correspondent',
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
    public function testArrayRecursive()
    {
        $epa = new Epa();
        $epa->setDonor(new Donor());
        $epa->addAttorney(new Attorney());
        $epa->addNotifiedRelative(new NotifiedRelative());
        $epa->addNotifiedAttorney(new NotifiedAttorney());
        $epa->addDocument($doc = new IncomingDocument());
        $doc->addPage(new Page());

        $this->assertEquals(
            array(
                'caseType'                                  => 'epa',
                'notifiedRelatives'                         => array(),
                'notifiedAttorneys'                         => array(),
                'epaDonorSignatureDate'                     => null,
                'donorHasOtherEpas'                         => false,
                'otherEpaInfo'                              => null,
                'donor'                                     => array (
                    'id'                                    => null,
                    'uId'                                   => null,
                    'normalizedUid'                         => null,
                    'documents'                             => array (),
                    'notes'                                 => array (),
                    'tasks'                                 => array (),
                    'inputFilter'                           => null,
                    'errorMessages'                         => array(),
                    'warnings'                              => array(),
                ),
                'correspondent'                             => null,
                'applicants'                                => array(),
                'attorneys'                                 => array(),
                'notifiedPersons'                           => array(),
                'usesNotifiedPersons'                       => false,
                'noNoticeGiven'                             => false,
                'notifiedPersonPermissionBy'                => 1,
                'certificateProviders'                      => array(),
                'paymentByDebitCreditCard'                  => 0,
                'paymentByCheque'                           => 0,
                'wouldLikeToApplyForFeeRemission'           => 0,
                'haveAppliedForFeeRemission'                => 0,
                'caseAttorneySingular'                      => false,
                'caseAttorneyJointlyAndSeverally'           => false,
                'caseAttorneyJointly'                       => false,
                'caseAttorneyJointlyAndJointlyAndSeverally' => false,
                'cardPaymentContact'                        => null,
                'howAttorneysAct'                           => null,
                'howReplacementAttorneysAct'                => null,
                'attorneyActDecisions'                      => null,
                'replacementAttorneyActDecisions'           => null,
                'replacementOrder'                          => null,
                'additionalInfo'                            => null,
                'paymentId'                                 => null,
                'paymentAmount'                             => null,
                'paymentDate'                               => null,
                'paymentRemission'                          => 0,
                'paymentExemption'                          => 0,
                'attorneyPartyDeclaration'                  => 1,
                'attorneyApplicationAssertion'              => 1,
                'attorneyMentalActPermission'               => 1,
                'attorneyDeclarationSignatureDate'          => null,
                'attorneyDeclarationSignatoryFullName'      => null,
                'correspondentComplianceAssertion'          => 1,
                'notificationDate'                          => null,
                'dispatchDate'                              => null,
                'noticeGivenDate'                           => null,
                'applicantType'                             => null,
                'cancellationDate'                          => null,
                'id'                                        => null,
                'oldCaseId'                                 => null,
                'applicationType'                           => 0,
                'title'                                     => null,
                'caseSubtype'                               => null,
                'dueDate'                                   => null,
                'registrationDate'                          => null,
                'closedDate'                                => null,
                'status'                                    => null,
                'tasks'                                     => array(),
                'notes'                                     => array(),
                'documents'                                 => array(),
                'caseItems'                                 => array(),
                'taskStatus'                                => array(),
                'ragRating'                                 => null,
                'ragTotal'                                  => null,
                'rejectedDate'                              => null,
                'scheduledJobs'                             => array(),
                'uId'                                       => null,
                'normalizedUid'                             => null,
                'inputFilter'                               => null,
                'errorMessages'                             => array(),
                'assignee'                                  => null,
                'epaDonorNoticeGivenDate'                   => null,
                'personNotifyDonor'                         => null,
                'hasRelativeToNotice'                       => null,
                'areAllAttorneysApplyingToRegister'         => null,
                'payments'                                  => array(),
                'applicantsDeclaration'                     => 1,
                'applicantsDeclarationSignatureDate'        => null,
                'caseAttorneyActionAdditionalInfo'          => false,
                'applicationHasRestrictions'                => false,
                'applicationHasGuidance'                    => false,
                'applicationHasCharges'                     => false,
                'certificateProviderSignatureDate'          => null,
                'attorneyStatementDate'                     => null,
                'signingOnBehalfDate'                       => null,
                'signingOnBehalfFullName'                   => null,
                'attorneyDeclarationSignatureWitness'       => false,
                'additionalInfoDonorSignature'              => false,
                'additionalInfoDonorSignatureDate'          => null,
                'anyOtherInfo'                              => false,
                'warnings'                                  => null,
            ),
            $epa->toArrayRecursive()
        );
    }

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

        $personNotifyDonor = new PersonNotifyDonor();
        $personNotifyDonor->setId('1');
        $this->epa->addPerson($personNotifyDonor);
        $this->assertEquals($personNotifyDonor, $this->epa->getPersonNotifyDonor());

        $notifiedRelative = new NotifiedRelative();
        $notifiedRelative->setId('1');
        $this->epa->addPerson($notifiedRelative);
        $this->assertEquals($notifiedRelative, $this->epa->getNotifiedRelatives()[0]);

        $notifiedAttorney = new NotifiedAttorney();
        $notifiedAttorney->setId('1');
        $this->epa->addPerson($notifiedAttorney);
        $this->assertEquals($notifiedAttorney, $this->epa->getNotifiedAttorneys()[0]);

        $correspondent = new Correspondent();
        $correspondent->setId('1');
        $this->epa->addPerson($correspondent);
        $this->assertEquals($correspondent, $this->epa->getCorrespondent());

        $person = $this->getMockForAbstractClass('Opg\Core\Model\Entity\CaseActor\Person');
        $person->setId('1');

        try {
            $this->epa->addPerson($person);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

    public function testGetSetPersonNotifyDonor()
    {
        $personNotifyDonor = new PersonNotifyDonor();
        $personNotifyDonor->setId('1');
        $this->epa->setPersonNotifyDonor($personNotifyDonor);
        $this->assertEquals($personNotifyDonor, $this->epa->getPersonNotifyDonor());

    }

    public function testGetSetAddNotifiedAttorney()
    {
        unset($this->epa->{'notifiedAttorneys'});
        $notifiedAttorney = new NotifiedAttorney();
        $notifiedAttorney->setId('1');
        $this->epa->addNotifiedAttorney($notifiedAttorney);
        $this->assertEquals($notifiedAttorney, $this->epa->getNotifiedAttorneys()[0]);

        unset($this->epa->{'notifiedAttorneys'});
        $notifiedAttorneys = $this->epa->getNotifiedAttorneys();
        $notifiedAttorneys->add($notifiedAttorney);
        $this->epa->setNotifiedAttorneys($notifiedAttorneys);
        $this->assertEquals($notifiedAttorney, $this->epa->getNotifiedAttorneys()[0]);
    }

    public function testGetSetAddNotifiedRelative()
    {
        unset($this->epa->{'notifiedRelatives'});
        $notifiedRelative = new NotifiedRelative();
        $notifiedRelative->setId('1');
        $this->epa->addNotifiedRelative($notifiedRelative);
        $this->assertEquals($notifiedRelative, $this->epa->getNotifiedRelatives()[0]);

        unset($this->epa->{'notifiedRelatives'});
        $notifiedRelatives = $this->epa->getNotifiedRelatives();
        $notifiedRelatives->add($notifiedRelative);
        $this->epa->setNotifiedRelatives($notifiedRelatives);
        $this->assertEquals($notifiedRelative, $this->epa->getNotifiedRelatives()[0]);
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
        $this->assertEmpty($this->epa->getDateAsString('epaDonorSignatureDate'));
        $this->epa->setDateFromString('','epaSignatureDate');

        $this->assertEmpty($this->epa->getDateAsString('epaDonorSignatureDate'));
    }

    public function testGetSetEpaDonorSignatureDateFromString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->epa->getDateAsString('epaDonorSignatureDate'));
        $this->epa->setDateFromString($expected, 'epaDonorSignatureDate');

        $this->assertEquals($expected, $this->epa->getDateAsString('epaDonorSignatureDate'));
    }

    public function testGetSetOtherEpa()
    {
        $expectedOtherEpas    = true;
        $expectedOtherEpaInfo = "Bacon ipsum dolor sit amet short ribs pork chop short loin ham hock est.";

        $this->assertFalse($this->epa->hasOtherEpas());

        $this->epa->setDonorHasOtherEpas($expectedOtherEpas);
        $this->epa->setOtherEpaInfo($expectedOtherEpaInfo);

        $this->assertTrue($this->epa->hasOtherEpas());
        $this->assertEquals($expectedOtherEpaInfo, $this->epa->getOtherEpaInfo());
    }

    public function testGetRagRatingRed()
    {
        $task = new Task();
        $task->setDateFromString(date('d/m/Y', strtotime('Last Week')),'dueDate');

        $this->epa->addTask($task);
        $this->epa->addTask($task);

        $this->assertEquals(3, $this->epa->getRagRating());
        $this->assertEquals(6, $this->epa->getRagTotal());
    }

    public function testGetRagRatingAmber()
    {
        $task = new Task();
        $task->setDateFromString(date('d/m/Y'),'dueDate');

        $this->epa->addTask($task);
        $this->epa->addTask($task);

        $this->assertEquals(2, $this->epa->getRagRating());
        $this->assertEquals(4, $this->epa->getRagTotal());
    }

    public function testGetRagRatingGreen()
    {
        $task = new Task();
        $task->setDateFromString(date('d/m/Y', strtotime('Next Week')),'dueDate');

        $this->epa->addTask($task);
        $this->epa->addTask($task);

        $this->assertEquals(1, $this->epa->getRagRating());
        $this->assertEquals(2, $this->epa->getRagTotal());
    }

    public function testFilterTasks()
    {
        $task = new Task();
        $task->setDateTimeFromString(date('d/m/Y 00:00:00', strtotime('next week')),'activeDate');
        $this->epa->addTask($task);

        $task2 = new Task();
        $task2->setDateTimeFromString(date('d/m/Y 00:00:00', strtotime('tomorrow')),'activeDate');
        $this->epa->addTask($task2);

        $task3 = new Task();
        $task3->setDateTimeFromString(date('d/m/Y 00:00:00', strtotime('yesterday')),'activeDate');
        $this->epa->addTask($task3);

        $this->assertEquals(1, count($this->epa->filterTasks()));
    }

    public function testUIDValidatorPassesInvalidChecksum()
    {
        $uid = '700000011440';

        $this->epa->setUid($uid);

        $this->assertTrue($this->epa->isValid(array('uId')));

        $this->assertEmpty($this->epa->getErrorMessages()['errors']);

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

        $this->assertEmpty($this->epa->getApplicantType());
        $this->epa->setApplicantType($expected);

        $this->assertEquals($expected, $this->epa->getApplicantType());
    }

    public function testGetSetHasRelativeToNotice()
    {
        $this->assertNull($this->epa->getHasRelativeToNotice());
        $this->epa->setHasRelativeToNotice(true);
        $this->assertTrue($this->epa->getHasRelativeToNotice());
        $this->epa->setHasRelativeToNotice(false);
        $this->assertFalse($this->epa->getHasRelativeToNotice());
    }

    public function testAreAllAttorneysApplyingToRegister()
    {
        $this->assertNull($this->epa->getAreAllAttorneysApplyingToRegister());
        $this->epa->setAreAllAttorneysApplyingToRegister(true);
        $this->assertTrue($this->epa->getAreAllAttorneysApplyingToRegister());
        $this->epa->setAreAllAttorneysApplyingToRegister(false);
        $this->assertFalse($this->epa->getAreAllAttorneysApplyingToRegister());
    }

    public function testGetSetEpaDonorNoticeGivenDate()
    {
        $expectedDate = new \DateTime();

        $this->epa->setEpaDonorNoticeGivenDate($expectedDate);

        $this->assertEquals($expectedDate, $this->epa->getEpaDonorNoticeGivenDate());

    }

    public function testGetSetEpaDonorNoticeGivenDateNulls()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->epa->getEpaDonorNoticeGivenDate());
        $this->epa->setEpaDonorNoticeGivenDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->epa->getEpaDonorNoticeGivenDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetEpaDonorNoticeGivenDateEmptyString()
    {
        $this->assertEmpty($this->epa->getDateAsString('epaDonorNoticeGivenDate'));
        $this->epa->setdateFromString('', 'epaDonorNoticeGivenDate');

        $this->assertEmpty($this->epa->getDateAsString('epaDonorNoticeGivenDate'));
    }

    public function testGetSetEpaDonorNoticeGivenDateFromString()
    {
        $expected = date(OPGDateFormat::getDateFormat());

        $this->assertEmpty($this->epa->getDateAsString('epaDonorNoticeGivenDate'));
        $this->epa->setdateFromString($expected, 'epaDonorNoticeGivenDate');

        $this->assertEquals($expected, $this->epa->getDateAsString('epaDonorNoticeGivenDate'));
    }
}

class EpaStub extends Epa
{
    public function __unset($key)
    {
        switch ($key) {
            case 'notifiedAttorneys' :
                $this->notifiedAttorneys = null;
                break;
            case 'notifiedRelatives' :
                $this->notifiedRelatives = null;
                break;
            default:
                throw new \Exception('Invalid EPA key is passed to unset() method.');
        }
    }
}
