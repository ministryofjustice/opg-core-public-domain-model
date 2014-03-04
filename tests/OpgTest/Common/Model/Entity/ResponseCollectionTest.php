<?php
namespace OpgTest\Common\Model\Entity;

use Opg\Common\Model\Entity\ResponseCollection;
use Opg\Core\Model\Entity\User\UserCollection;
use Opg\Core\Model\Entity\User\User;

/**
 * ResponseCollection test case.
 */
class ResponseCollectionTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ResponseCollection
     */
    private $responseCollection;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->responseCollection = new ResponseCollection();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->search = null;

        parent::tearDown();
    }

    public function testSetGetData()
    {
        $collectionMock = \Mockery::mock('Opg\Common\Model\Entity\CollectionInterface');
        $collectionMock->shouldReceive('getData')->andReturn(['test'=>123]);
        
        $this->responseCollection->setData($collectionMock);
        
        $this->assertEquals(
            $collectionMock,
            $this->responseCollection->getData()
        );
    }
    
    public function testSetGetTotal()
    {
        $total = 100;
        
        $this->responseCollection->setTotal($total);
        
        $this->assertEquals(
            $total,
            $this->responseCollection->getTotal()
        );
    }
    
    public function testToArray()
    {
        $userCollection = new UserCollection();
        for ($i=1; $i<=2; $i++) {
            $user = new User();
            $user->setFirstname('User' . $i);
            $userCollection->addUser($user);
        }
    
        $this->responseCollection->setData($userCollection);
    
        $expected = [
            'data' => [
                0 => ['firstname' => 'User1'],
                1 => ['firstname' => 'User2'],
            ],
            'total' => 2,
        ];

        $actual = $this->responseCollection->toArray();
        
        $this->assertEquals(
            'User1',
            $actual['data'][0]['firstname']
        );
        
        $this->assertEquals(
            'User2',
            $actual['data'][1]['firstname']
        );
        
        $this->assertEquals(
            '2',
            $actual['total']
        );
    }
}
