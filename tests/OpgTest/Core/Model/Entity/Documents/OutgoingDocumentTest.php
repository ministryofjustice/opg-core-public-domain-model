<?php
namespace OpgTest\Core\Model\Entity\Documents;

use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\Document\Document;
use PHPUnit_Framework_TestCase;
use Opg\Core\Model\Entity\Document\OutgoingDocument;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class OutgoingDocumentTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var OutgoingDocument
     */
    private $correspondence;

    private $data = array(
        'id'            => '123',
        'type'          => null,
        'filename'      => null,
        'case'          => null,
        'person'        => null,
        'errorMessages' => array(),
        'recipientName' => null,
        'address'       => null,
        'systemType'    => null,
    );

    public function setUp()
    {
        $this->correspondence = new OutgoingDocument();
    }

    public function testGetIterator()
    {
        $this->assertInstanceOf('RecursiveArrayIterator', $this->correspondence->getIterator());
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
        $donor->setFirstname('Test')->setSurname('Recipient');
        $address = new Address();
        $address->setAddressLine('Test Address')->setTown('Some Town')->setPostcode('Postcode');
        $donor->addAddress($address);

        $this->correspondence->setCorrespondent($donor);
        $this->assertInstanceOf('Opg\Core\Model\Entity\CaseActor\Donor', $this->correspondence->getCorrespondent());

        $this->assertEquals($donor, $this->correspondence->getCorrespondent());
        $this->assertEquals($address, $this->correspondence->getCorrespondent()->getAddresses()->toArray()[0]);
    }

    public function testSetGetDocumentStoreFilename()
    {
        $this->correspondence->setId('10');
        $this->correspondence->setFilename('document');
        $expectedOutput = '10_document';
        $this->assertEquals($expectedOutput, $this->correspondence->getDocumentStoreFilename());
    }

    public function testGetSetSystemType()
    {
        $expected = 'LP-3A';

        $this->assertEmpty($this->correspondence->getSystemType());
        $this->assertTrue($this->correspondence->setSystemType($expected) instanceof Document);
        $this->assertEquals($expected, $this->correspondence->getSystemType());
    }

    public function testGetSetCreatedDateNulls()
    {
        $expectedDate = new \DateTime();
        $this->assertNotEmpty($this->correspondence->getCreatedDate());
        $this->correspondence->setCreatedDate();
        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateTimeFormat()),
            $this->correspondence->getCreatedDate()->format(OPGDateFormat::getDateTimeFormat())
        );
    }

    public function testGetSetCreatedDate()
    {
        $expected = date(OPGDateFormat::getDateTimeFormat());
        $this->correspondence->setDateTimeFromString($expected, 'createdDate');
        $this->assertEquals($expected, $this->correspondence->getDateTimeAsString('createdDate'));
    }


    public function testGetSetCreatedDateEmptyString()
    {
        $expectedDate = new \DateTime();
        $this->correspondence->setDateTimeFromString(null, 'createdDate');
        $returnedDate = $this->correspondence->getCreatedDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateTimeFormat()),
            $returnedDate->format(OPGDateFormat::getDateTimeFormat())
        );
    }

    public function testGetSetType()
    {
        $expected = 'Client Notification';

        $this->correspondence->setType($expected);

        $this->assertEquals($expected, $this->correspondence->getType());
    }
}
