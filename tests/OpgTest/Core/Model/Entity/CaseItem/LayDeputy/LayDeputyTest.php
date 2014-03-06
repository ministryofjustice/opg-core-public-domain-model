<?php


namespace OpgTest\Common\Model\Entity\CaseItem\LayDeputy;


use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\LayDeputy\LayDeputy;

class LayDeputyTest extends \PHPUnit_Framework_TestCase
{

    protected $layDeputy;

    public function setUp()
    {
        $this->layDeputy = new LayDeputy();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->layDeputy instanceof LayDeputy);
    }

    public function testSetId()
    {
        $expectedID = '1234560';
        $this->layDeputy->setId($expectedID);
        $this->assertEquals($expectedID, $this->layDeputy->getId());
    }

    public function testGetSetInputFilter()
    {
        $mockInputFilter = $this->getMockForAbstractClass('Zend\InputFilter\InputFilterInterface');

        try {
            $this->layDeputy->setInputFilter($mockInputFilter);
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }

        try {
            $this->layDeputy->getInputFilter();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof \LogicException);
            $this->assertFalse($e instanceof UnusedException);
        }
    }

}