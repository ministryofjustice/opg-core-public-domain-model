<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;

/**
 * Applicant test case.
 */
class ApplicantCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ApplicantCollection
     */
    private $applicantCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->applicantCollection = new ApplicantCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->applicant = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoApplicantsAdded()
    {
        $expected = [];
        $actual = $this->applicantCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $applicant = new Attorney();
            
            $applicant->setId($i);
            
            $this->applicantCollection->addApplicant(
                $applicant
            );
        }
        
        $applicant = new Attorney();
        
        $this->applicantCollection->addApplicant(
            $applicant
        );
    }
    
    public function testValidWhenDonorInCollection()
    {
        $result = $this->applicantCollection->addApplicant(
            new Donor()
        );
        
        $this->assertTrue($result instanceof ApplicantCollection);
        
        $this->assertTrue($this->applicantCollection->isValid());
    }
    
    public function testValidWhenOneAttorneyInCollection()
    {
        $result = $this->applicantCollection->addApplicant(
            new Attorney()
        );
    
        $this->assertTrue($result instanceof ApplicantCollection);
        
        $this->assertTrue($this->applicantCollection->isValid());
    }
    
    public function testValidWhenMultipleAttorneysInCollection()
    {
        for ($i=0; $i<10; $i++) {
            $result = $this->applicantCollection->addApplicant(
                new Attorney()
            );
            
            $this->assertTrue($result instanceof ApplicantCollection);
        }

        $this->assertTrue($this->applicantCollection->isValid());
    }
    
    public function testInvalidWhenDonorInCollectionAndMoreThanOneApplicant()
    {
        $result = $this->applicantCollection->addApplicant(
            new Attorney()
        );
    
        $this->assertTrue($result instanceof ApplicantCollection);

        $result = $this->applicantCollection->addApplicant(
            new Donor()
        );
        
        $this->assertTrue($result instanceof ApplicantCollection);
        
        $this->assertFalse($this->applicantCollection->isValid());

        $errors = array(
            'errors' => array(
                'applicantCollection' => array(
                    'invalidPartyCombination' => 'An applicant collection must be either (a) a donor, or (b) one or more attorneys'
                )
            )
        );

        $this->assertEquals($errors, $this->applicantCollection->getErrorMessages());
    }
    
    public function testInvalidWhenWrongApplicantType()
    {
        $result = $this->applicantCollection->addApplicant(
            new NotifiedPerson()
        );
    
        $this->assertTrue($result instanceof ApplicantCollection);
    
        $this->assertFalse($this->applicantCollection->isValid());
    }
    
    public function testInvalidWhenZeroApplicants()
    {
        $this->assertFalse($this->applicantCollection->isValid());
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
        
        $this->assertEquals(
            $this->applicantCollection->getData(),
            $this->applicantCollection->getApplicantCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->applicantCollection->toArray();
        
        $expected = 11;
        $actual = count($array['applicantCollection']);
        
        $this->assertEquals(
            $expected,
            $actual
        );
        
        for ($i=0; $i<10; $i++) {
            $this->assertEquals(
                $i,
                $array['applicantCollection'][$i]->getId()
            );
        }
    }
    
    public function testGetIterator()
    {
        $iterator = $this->applicantCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
//     public function testThrowsExceptionOnUnusedExchangeArrayMethod()
//     {
//         $this->setExpectedException('Opg\Common\Exception\UnusedException');
//         $this->applicantCollection->exchangeArray([]);
//     }
}
