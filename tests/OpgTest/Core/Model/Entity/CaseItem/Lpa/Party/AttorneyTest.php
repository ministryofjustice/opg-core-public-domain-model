<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;

use Opg\Common\Exception\UnusedException;
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

    public function testSetGetIsTrustCorporation()
    {
        $this->attorney->setIsTrustCorporation(true);
        $this->assertTrue($this->attorney->isTrustCorporation());

        $this->attorney->setIsTrustCorporation(false);
        $this->assertFalse($this->attorney->isTrustCorporation());
    }

    public function testSetGetIsReplacementAttorney()
    {
        $this->attorney->setIsReplacementAttorney(true);
        $this->assertTrue($this->attorney->isReplacementAttorney());

        $this->attorney->setIsReplacementAttorney(false);
        $this->assertFalse($this->attorney->isReplacementAttorney());
    }

    public function testgetSetInputFilter()
    {
        try {
            $this->attorney->setInputFilter(new InputFilter());
        }
        catch(\Exception $e) {
            $this->assertTrue($e instanceof UnusedException);
        }

        try {
            $this->attorney->getInputFilter();
        }
        catch(\Exception $e){
            $this->assertTrue($e instanceof UnusedException);
        }
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
}
