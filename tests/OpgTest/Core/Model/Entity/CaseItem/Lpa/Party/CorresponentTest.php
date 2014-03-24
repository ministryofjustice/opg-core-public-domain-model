<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface;
use Opg\Common\Exception\UnusedException;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;

/**
 * ToArray test case.
 */
class CorrespondentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Correspondent
     */
    private $correspondent;

    public function setUp()
    {
        $this->correspondent = new Correspondent();
    }

    public function testCreate()
    {
        $this->assertTrue($this->correspondent instanceof Correspondent);
        $this->assertTrue($this->correspondent instanceof PartyInterface);
        $this->assertTrue($this->correspondent instanceof EntityInterface);
    }

    public function testToArrayExchangeArray()
    {
        $this->correspondent->setId('1');

        $correspondentArray = $this->correspondent->toArray();

        $correspondentCopy = $this->correspondent->exchangeArray($correspondentArray);

        $this->assertArrayHasKey('className',$correspondentArray);
        $this->assertEquals(get_class($correspondentCopy), $correspondentArray['className']);
        $this->assertEquals($this->correspondent, $correspondentCopy);
        $this->assertEquals($correspondentArray, $correspondentCopy->toArray());
    }

    public function testIsValid()
    {
        $this->assertFalse($this->correspondent->isValid());

        $errors = $this->correspondent->getErrorMessages();
        $this->assertArrayHasKey('surname',$errors['errors']);
        $this->assertArrayHasKey('powerOfAttorneys',$errors['errors']);

        $this->correspondent->addCase(new Lpa());
        $this->correspondent->setSurname('Test-Surname');
        $this->assertTrue($this->correspondent->isValid());
    }

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Siblig';
        $this->correspondent->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->correspondent->getRelationshipToDonor());
    }
}
