<?php
namespace OpgTest\Core\Model\Entity\Correspondence;

use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use PHPUnit_Framework_TestCase;
use Opg\Core\Model\Entity\Correspondence\Correspondence;

class CorrespondenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \Opg\Core\Model\Entity\Correspondence\Correspondence;
     */
    private $correspondence;

    private $data = array(
        'id'            => '123',
        'type'          => null,
        'filename'       => null,
        'case'          => null,
        'person'        => null,
        'errorMessages' => array()
    );

    public function setUp()
    {
        $this->correspondence = new Correspondence();
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->correspondence->getIterator());

        $this->correspondence->exchangeArray($this->data);
        $this->assertEquals($this->data, $this->correspondence->getIterator()->getArrayCopy());
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->correspondence->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter);
    }

    public function testSetGetId()
    {
        $this->correspondence->setId($this->data['id']);

        $this->assertEquals($this->data['id'], $this->correspondence->getId());
    }

    public function testSetGetFileName()
    {
        $filename = 'TestFile';
        $this->correspondence->setFilename($filename);
        $this->assertEquals($filename, $this->correspondence->getFilename());
    }

    public function testSetGetCase()
    {
        $case = new Lpa();
        $this->correspondence->setCase($case);
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseItem\Lpa\Lpa', $this->correspondence->getCase());
    }

    public function testSetGetPerson()
    {
        $donor = new Donor();
        $this->correspondence->setPerson($donor);
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor', $this->correspondence->getPerson());
    }

    public function testSetGetDocumentStoreFilename()
    {
        $this->correspondence->setId('10');
        $this->correspondence->setFilename('document');
        $expectedOutput = '10_document';
        $this->assertEquals($expectedOutput,$this->correspondence->getDocumentStoreFilename());
    }

    public function testExchangeArray()
    {
        $data = array (
            'id'    => 123,
            'type'  => 'unknown document'
        );

        $this->correspondence->exchangeArray($data);

        $this->assertEquals($data['id'], $this->correspondence->getId());
        $this->assertEquals($data['type'], $this->correspondence->getType());
    }
}
