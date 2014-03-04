<?php
namespace OpgTest\Core\Model\Entity\CaseItem\User;

use Opg\Core\Model\Entity\User\UserCollection;
use Opg\Core\Model\Entity\User\User;

/**
 * User test case.
 */
class UserCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var UserCollection
     */
    private $userCollection;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
                
        $this->userCollection = new UserCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->user = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
    }

    public function testReturnsEmptyArrayWhenNoUsersAdded()
    {
        $expected = [];
        $actual = $this->userCollection->getData();
        
        $this->assertEquals($expected, $actual);
    }
    
    private function populateCollection()
    {
        for ($i=0; $i<10; $i++) {
            $user = new User();
            $user->setId($i);
            $user->setRealname('Testname');
    
            $this->userCollection->addUser(
                $user
            );
        }
    }
    
    public function testGetDataAlias()
    {
        $this->populateCollection();
    
        $this->assertEquals(
            $this->userCollection->getData(),
            $this->userCollection->getUserCollection()
        );
    }
    
    public function testToArray()
    {
        $this->populateCollection();
        $array = $this->userCollection->toArray();
    
        $expected = 10;
        $actual = count($array);
    
        $this->assertEquals(
            $expected,
            $actual
        );
    
        for ($i=0; $i<10; $i++) {
            $this->assertEquals(
                $i,
                $array[$i]['id']
            );
        }
    }
    
    public function testGetIterator()
    {
        $iterator = $this->userCollection->getIterator();
    
        $this->assertInstanceOf('ArrayIterator', $iterator);
    }
    
    public function testThrowsExceptionOnUnusedExchangeArrayMethod()
    {
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->userCollection->exchangeArray([]);
    }
    
    public function testGetInputFilter()
    {
        $inputFilter = $this->userCollection->getInputFilter();
    
        $this->assertInstanceOf(
            'Zend\InputFilter\InputFilterInterface',
            $inputFilter
        );
    }
}
