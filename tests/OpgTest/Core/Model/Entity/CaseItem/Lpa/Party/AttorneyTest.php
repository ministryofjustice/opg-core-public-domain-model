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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpa002SignatureDate());
        $this->attorney->setLpa002SignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->attorney->getLpa002SignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpa002SignatureDateString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpa002SignatureDateString());
        $this->attorney->setLpa002SignatureDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->attorney->getLpa002SignatureDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
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
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());
        $this->attorney->setLpaPartCSignatureDate();

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $this->attorney->getLpaPartCSignatureDate()->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetLpaPartCSignatureDateString()
    {
        $expectedDate = new \DateTime();

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDateString());
        $this->attorney->setLpaPartCSignatureDateString('');

        $returnedDate =
            \DateTime::createFromFormat(
                OPGDateFormat::getDateFormat(),
                $this->attorney->getLpaPartCSignatureDateString()
            );

        $this->assertEquals(
            $expectedDate->format(OPGDateFormat::getDateFormat()),
            $returnedDate->format(OPGDateFormat::getDateFormat())
        );
    }

    public function testGetSetIsAttorneyApplyingToRegister()
    {
        $this->assertEquals(Attorney::OPTION_NOT_SET, $this->attorney->getIsAttorneyApplyingToRegister());

        $this->attorney->setIsAttorneyApplyingToRegister(Attorney::OPTION_FALSE);
        $this->assertEquals(Attorney::OPTION_FALSE, $this->attorney->getIsAttorneyApplyingToRegister());
        $this->assertNotEquals(Attorney::OPTION_TRUE, $this->attorney->getIsAttorneyApplyingToRegister());
    }
}
