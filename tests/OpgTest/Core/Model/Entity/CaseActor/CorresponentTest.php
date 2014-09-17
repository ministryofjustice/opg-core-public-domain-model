<?php
namespace OpgTest\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\CaseActor\PartyInterface;
use Opg\Core\Model\Entity\CaseActor\Correspondent;


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

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Sibling';
        $this->correspondent->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->correspondent->getRelationshipToDonor());
    }
}
