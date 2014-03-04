<?php
namespace OpgTest\Core\Model\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Party\PartyCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantCollection;

/**
 * Lpa test case.
 */
class LpaTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Lpa
     */
    private $lpa;

    /**
     * Prepares the environment before running a test.
     */
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

    public function testGetsetCaseId()
    {
        $caseId = '1234567/123';
        
        $this->lpa->setCaseId($caseId);
        
        $this->assertEquals(
            $caseId,
            $this->lpa->getCaseId()
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
        $applicantCollection = new ApplicantCollection();
        $this->lpa->setApplicantCollection($applicantCollection);
    
        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantCollection',
            $this->lpa->getApplicantCollection()
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
        $attorneyCollection = new PartyCollection();
        $this->lpa->setAttorneyCollection($attorneyCollection);
    
        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Party\PartyCollection',
            $this->lpa->getAttorneyCollection()
        );
    }
    
    public function testGetSetNotifiedPersonCollection()
    {
        $notifiedPersonCollection = new PartyCollection();
        $this->lpa->setNotifiedPersonCollection($notifiedPersonCollection);
    
        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Party\PartyCollection',
            $this->lpa->getNotifiedPersonCollection()
        );
    }
    
    public function testGetSetCertificateProviderCollection()
    {
        $certificateProviderCollection = new PartyCollection();
        $this->lpa->setCertificateProviderCollection($certificateProviderCollection);
    
        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\CaseItem\Party\PartyCollection',
            $this->lpa->getCertificateProviderCollection()
        );
    }
    
    public function testGetSetPaymentMethod()
    {
        $expected = 'CARD';
    
        $this->lpa->setPaymentMethod($expected);
    
        $this->assertEquals(
            $expected,
            $this->lpa->getPaymentMethod()
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
        
    public function testGetSetBacsPaymentInstructions()
    {
        $expected = 'These are the instructions you wanted';
    
        $this->lpa->setBacsPaymentInstructions($expected);
    
        $this->assertEquals(
            $expected,
            $this->lpa->getBacsPaymentInstructions()
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
    
    public function testPaymentMethodValidation()
    {
        $this->assertFalse($this->lpa->isValid(['paymentMethod']));
        
        $this->lpa->setPaymentMethod('Cash in hand');
        $this->assertFalse($this->lpa->isValid(['paymentMethod']));
        
        $this->lpa->setPaymentMethod('CARD');
        $this->assertTrue($this->lpa->isValid(['paymentMethod']));
        
        $this->lpa->setPaymentMethod('CHEQUE');
        $this->assertTrue($this->lpa->isValid(['paymentMethod']));
        
        $this->lpa->setPaymentMethod('BACS');
        $this->assertTrue($this->lpa->isValid(['paymentMethod']));
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
        $applicants = new ApplicantCollection();
        $applicants->addApplicant(new Donor());
        
        $this->lpa->setApplicantCollection($applicants);
        
        $this->assertTrue($this->lpa->isValid(['applicantCollection']));
    }
    
    public function testValidationTraversalDownToInvalidApplicantCollection()
    {
        $applicants = new ApplicantCollection();
        $applicants->addApplicant(new Donor());
        $applicants->addApplicant(new Attorney());
    
        $this->lpa->setApplicantCollection($applicants);
    
        $this->assertFalse($this->lpa->isValid(['applicantCollection']));
        

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
            'caseId' => '12345ABC/123'
        );
    
        $this->lpa->exchangeArray($data);
    
        $this->assertEquals(
            $data['caseId'],
            $this->lpa->getCaseId()
        );
    }
}
