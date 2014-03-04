<?php
namespace OpgTest\Core\Model\Entity\Address;

use Opg\Core\Model\Entity\Address\Address;

/**
 * Address test case.
 */
class AddressTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Address
     */
    private $address;

    /**
     * @var array
     */
    private $testData;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->address = new Address();

        $this->testData = array(
            'country'      => 'TestCountry',
            'town'         => 'TestTown',
            'county'       => 'TestCounty',
            'addressLines' => [1, 2, 3],
            'postcode'     => 'SW3 4HG',
            'errorMessages'=> array()
        );
    }

    /**
     * Kept it simple as validation rules should go to its own class
     */
    public function testGetInputFilter()
    {
        $inputFilter = $this->address->getInputFilter();

        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $inputFilter); 
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->address = null;

        parent::tearDown();
    }

    public function testGetSetAddressLines()
    {
        $addressLines = [
            '1',
            '2',
        ];

        $this->address->setAddressLines($addressLines);

        $this->assertEquals(
            $addressLines,
            $this->address->getAddressLines()
        );
    }

    public function testGetSetTown()
    {
        $town = 'Sussex';

        $this->assertInstanceOf('Opg\Core\Model\Entity\Address\Address', $this->address->setTown($town));

        $this->assertEquals(
            $town,
            $this->address->getTown()
        );
    }

    public function testGetSetCounty()
    {
        $county = 'Sussex';

        $this->assertInstanceOf('Opg\Core\Model\Entity\Address\Address', $this->address->setCounty($county));

        $this->assertEquals(
            $county,
            $this->address->getCounty()
        );
    }

    public function testGetSetCountry()
    {
        $country = 'Wales';

        $this->assertInstanceOf('Opg\Core\Model\Entity\Address\Address', $this->address->setCountry($country));

        $this->assertEquals(
            $country,
            $this->address->getCountry()
        );
    }

    public function testGetSetPostcode()
    {
        $postcode = 'SW3 YHF';

        $this->assertInstanceOf('Opg\Core\Model\Entity\Address\Address', $this->address->setPostcode($postcode));

        $this->assertEquals(
            $postcode,
            $this->address->getPostcode()
        );
    }

    public function testExchangeArray()
    {
        $this->testData = array(
            'country'      => 'TestCountry',
            'town'         => 'TestTown',
            'county'       => 'TestCounty',
            'addressLines' => [1, 2, 3],
            'postcode'     => 'SW3 4HG',
        );

        $this->assertInstanceOf(
            'Opg\Core\Model\Entity\Address\Address',
            $this->address->exchangeArray($this->testData)
        );

        $this->assertEquals(
            $this->testData['country'],
            $this->address->getCountry()
        );

        $this->assertEquals(
            $this->testData['town'],
            $this->address->getTown()
        );

        $this->assertEquals(
            $this->testData['county'],
            $this->address->getCounty()
        );

        $this->assertEquals(
            $this->testData['postcode'],
            $this->address->getPostcode()
        );

        $this->assertEquals(
            $this->testData['addressLines'],
            $this->address->getAddressLines()
        );
    }

    public function testGetArrayCopy()
    {
        $this->address->exchangeArray($this->testData);

        $returnArray = $this->address->getArrayCopy();

        unset($returnArray['inputFilter']);

        $this->assertTrue(
            is_array($returnArray)
        );

        $this->assertEquals(
            $this->testData,
            $returnArray
        );
    }

    public function testNoErrorMessages()
    {
        $this->assertEquals(
            array('errors' => array()),
            $this->address->getErrorMessages()
        );
    }
}
