<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;

use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;

class AttorneyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Attorney
     */
    private $attorney;

    public function setUp()
    {
        $this->attorney = new Attorney();
    }

    public function testSetGetRelationshipToDonor()
    {
        $expected = 'Test Relationship';

        $this->attorney->setRelationshipToDonor($expected);
        $this->assertEquals(
            $expected,
            $this->attorney->getRelationshipToDonor()
        );
    }

    public function testSetGetOccupation()
    {
        $expected = 'Test Occupation';

        $this->attorney->setOccupation($expected);
        $this->assertEquals(
            $expected,
            $this->attorney->getOccupation()
        );
    }

    public function testToArrayExchangeArray()
    {
        $this->attorney
            ->setId('1')
            ->setEmail('attorney@domain.com')
            ->setCases(new ArrayCollection());


        $attorneyArray = $this->attorney->toArray();

        $attorney2 = $this->attorney->exchangeArray($attorneyArray);

        $this->assertArrayHasKey('className',$attorneyArray);
        $this->assertEquals(get_class($attorney2), $attorneyArray['className']);
        $this->assertEquals($this->attorney, $attorney2);
        $this->assertEquals($attorneyArray, $attorney2->toArray());
    }

    public function testIsValid()
    {
        $this->markTestSkipped('Validation has been removed');

        $this->assertFalse($this->attorney->isValid());

        $errors = $this->attorney->getErrorMessages();
        $this->assertArrayHasKey('surname',$errors['errors']);
        $this->assertArrayHasKey('powerOfAttorneys',$errors['errors']);

        $this->attorney->addCase(new Lpa());
        $this->attorney->setSurname('Test-Surname');
        $this->assertTrue($this->attorney->isValid());
    }

    public function testGetLpa002SignatureDate()
    {
        $expected = date('Y-m-d');

        $this->assertNull($this->attorney->getLpa002SignatureDate());
        $this->attorney->setLpa002SignatureDate($expected);

        $this->assertEquals($expected, $this->attorney->getLpa002SignatureDate());
    }

    public function testGetSetLpaPartCSignatureDate()
    {
        $expected = date('Y-m-d');

        $this->assertNull($this->attorney->getLpaPartCSignatureDate());
        $this->attorney->setLpaPartCSignatureDate($expected);

        $this->assertEquals($expected, $this->attorney->getLpaPartCSignatureDate());
    }

    public function testGetSetIsAttorneyApplyingToRegister()
    {
        $this->assertEquals(Attorney::OPTION_NOT_SET, $this->attorney->getIsAttorneyApplyingToRegister());

        $this->attorney->setIsAttorneyApplyingToRegister(Attorney::OPTION_FALSE);
        $this->assertEquals(Attorney::OPTION_FALSE, $this->attorney->getIsAttorneyApplyingToRegister());
        $this->assertNotEquals(Attorney::OPTION_TRUE, $this->attorney->getIsAttorneyApplyingToRegister());
    }
}
