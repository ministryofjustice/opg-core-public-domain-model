<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;

class NotifiedPersonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NotifiedPerson
     */
    private $notifiedPerson;
   
    public function setUp()
    {
        $this->notifiedPerson = new NotifiedPerson();
    }
    
    public function testSetGetNotifiedPerson()
    {
        $expected = '1993-11-22';
        
        $this->notifiedPerson->setNotifiedDate($expected);
    
        $this->assertEquals(
            $expected,
            $this->notifiedPerson->getNotifiedDate()
        );
    }
}
