<?php
namespace OpgTest\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Model\Entity\CaseActor\Attorney;

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

    public function testGetSetLpa002SignatureDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpa002SignatureDate());
        $this->assertEmpty($this->attorney->getDateAsString('lpa002SignatureDate'));

        $this->attorney->setLpa002SignatureDate($expectedDate);
        $this->assertEquals($expectedDate, $this->attorney->getLpa002SignatureDate());

    }

    public function testGetSetLpa002SignatureDateNulls()
    {
        $this->assertEmpty($this->attorney->getLpa002SignatureDate());
        $this->attorney->setLpa002SignatureDate();

        $this->assertEmpty($this->attorney->getLpa002SignatureDate());
    }

    public function testGetSetLpa002SignatureInvalidString()
    {
        try {
            $this->attorney->setDateFromString('asdfadsfsa', 'lpa002SignatureDate');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asdfadsfsa' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
        $this->assertEmpty($this->attorney->getDateAsString('lpa002SignatureDate'));
    }

    public function testGetSetLpa002SignatureString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->attorney->setDateFromString($expected, 'lpa002SignatureDate');
        $this->assertEquals($expected, $this->attorney->getDateAsString('lpa002SignatureDate'));
    }

    public function testGetSetLpa002SignatureEmptyString()
    {
        $this->attorney->setDateFromString('', 'lpa002SignatureDate');
        $this->assertEmpty($this->attorney->getDateAsString('lpa002SignatureDate'));
    }

    public function testGetSetLpaPartCSignatureDate()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());
        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());
        $this->attorney->setLpaPartCSignatureDate($expectedDate);

        $this->assertEquals($expectedDate, $this->attorney->getLpaPartCSignatureDate());
    }

    public function testGetSetLpaPartCSignatureDateNulls()
    {
        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());
        $this->attorney->setLpaPartCSignatureDate();

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());
    }

    public function testGetSetLpaPartCSignatureInvalidString()
    {
        try {
            $this->attorney->setLpaPartCSignatureDateString('asdfadsfsa');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asdfadsfsa' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());
    }

    public function testGetSetLpaPartCSignatureString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->attorney->setLpaPartCSignatureDateString($expected);
        $this->assertEquals($expected, $this->attorney->getLpaPartCSignatureDateString());
    }

    public function testGetSetLpaPartCSignatureEmptyString()
    {
        $expected = '';
        $this->attorney->setLpaPartCSignatureDateString($expected);
        $this->assertEquals($expected, $this->attorney->getLpaPartCSignatureDateString());
    }

    public function testGetSetIsAttorneyApplyingToRegister()
    {
        $this->assertEquals(Attorney::OPTION_NOT_SET, $this->attorney->getIsAttorneyApplyingToRegister());

        $this->attorney->setIsAttorneyApplyingToRegister(false);
        $this->assertFalse($this->attorney->getIsAttorneyApplyingToRegister());
        $this->assertNotEquals(true, $this->attorney->getIsAttorneyApplyingToRegister());

        $this->attorney->setIsAttorneyApplyingToRegister(true);
        $this->assertTrue($this->attorney->getIsAttorneyApplyingToRegister());
        $this->assertNotEquals(false, $this->attorney->getIsAttorneyApplyingToRegister());

        $this->attorney->setIsAttorneyApplyingToRegister();
        $this->assertEquals(Attorney::OPTION_NOT_SET, $this->attorney->getIsAttorneyApplyingToRegister());
    }

    public function testUnsetIsAttorneyApplyingToRegister()
    {
        $this->assertEquals(Attorney::OPTION_NOT_SET, $this->attorney->getIsAttorneyApplyingToRegister());
        $this->attorney->setIsAttorneyApplyingToRegister();
        $this->assertNotNull($this->attorney->getIsAttorneyApplyingToRegister());
    }

    public function testGetInputFilter()
    {
        $this->assertTrue($this->attorney->getInputFilter() instanceof \Zend\InputFilter\InputFilter);
    }

}
