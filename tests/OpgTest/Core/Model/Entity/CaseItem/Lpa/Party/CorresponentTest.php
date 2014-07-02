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

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Sibling';
        $this->correspondent->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->correspondent->getRelationshipToDonor());
    }
}
