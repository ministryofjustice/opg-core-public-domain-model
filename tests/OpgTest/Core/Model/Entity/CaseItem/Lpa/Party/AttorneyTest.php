<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;

use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

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
        $this->assertEmpty($this->attorney->getLpa002SignatureDateString());

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
            $this->attorney->setLpa002SignatureDateString('asdfadsfsa');
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof \Opg\Common\Model\Entity\Exception\InvalidDateFormatException);
            $this->assertEquals("'asdfadsfsa' was not in the expected format d/m/Y H:i:s", $e->getMessage());
        }
        $this->assertEmpty($this->attorney->getLpa002SignatureDateString());
    }

    public function testGetSetLpa002SignatureString()
    {
        $expected = date(OPGDateFormat::getDateFormat());
        $this->attorney->setLpa002SignatureDateString($expected);
        $this->assertEquals($expected, $this->attorney->getLpa002SignatureDateString());
    }

    public function testGetSetLpa002SignatureEmptyString()
    {
        $this->attorney->setLpa002SignatureDateString('');
        $this->assertEmpty($this->attorney->getLpa002SignatureDateString());
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

        $this->attorney->setIsAttorneyApplyingToRegister(Attorney::OPTION_FALSE);
        $this->assertEquals(Attorney::OPTION_FALSE, $this->attorney->getIsAttorneyApplyingToRegister());
        $this->assertNotEquals(Attorney::OPTION_TRUE, $this->attorney->getIsAttorneyApplyingToRegister());
    }

    public function testGetInputFilter()
    {
        $this->assertTrue($this->attorney->getInputFilter() instanceof \Zend\InputFilter\InputFilter);
    }

}
