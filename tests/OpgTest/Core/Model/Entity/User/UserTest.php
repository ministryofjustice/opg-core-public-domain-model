<?php
namespace OpgTest\Core\Model\Entity\User;

use Opg\Core\Model\Entity\User\User;
use Opg\Core\Model\Entity\CaseItem\CaseItemCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

/**
 * User test case.
 */
class UserTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var User
     */
    private $user;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->user = new User();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->user = null;

        parent::tearDown();
    }

    public function testGetSetId()
    {
        $id = '123123123';

        $ret = $this->user->setId($id);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $id,
            $this->user->getId()
        );
    }

    public function testGetSetRealname()
    {
        $username = 'TestUser';

        $ret = $this->user->setUsername($username);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $username,
            $this->user->getUsername()
        );
    }

    public function testGetSetFirstname()
    {
        $expected = 'Firstname';

        $ret = $this->user->setFirstname($expected);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $expected,
            $this->user->getFirstname()
        );
    }

    public function testGetSetSurname()
    {
        $expected = 'Surname';

        $ret = $this->user->setSurname($expected);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $expected,
            $this->user->getSurname()
        );
    }

    public function testGetSetEmail()
    {
        $expected = 'Email';

        $ret = $this->user->setEmail($expected);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $expected,
            $this->user->getEmail()
        );
    }

    public function testGetSetPassword()
    {
        $expected = 'Password';

        $ret = $this->user->setPassword($expected);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $expected,
            $this->user->getPassword()
        );
    }

    public function testGetSetToken()
    {
        $expected = 'Token';

        $ret = $this->user->setToken($expected);

        $this->assertSame($ret, $this->user);

        $this->assertEquals(
            $expected,
            $this->user->getToken()
        );
    }

    public function testRoles()
    {
        $role1 = "TestRole1";
        $role2 = "TestRole2";

        // Check the user start life with no roles.
        $this->assertFalse($this->user->hasRole($role1));

        // Check that adding a role works
        $this->user->addRole($role1);

        $this->assertTrue($this->user->hasRole($role1));

        // Check that removing a role works
        $this->user->removeRole($role1);

        $this->assertFalse($this->user->hasRole($role1));

        // Check that clearing roles works.
        $this->user->addRole($role1);
        $this->user->addRole($role2);

        $this->assertEquals(array($role1 => null, $role2 => null), $this->user->getRoles());

        $this->assertTrue($this->user->hasRole($role1));
        $this->assertTrue($this->user->hasRole($role2));

        $this->user->clearRoles();

        $this->assertFalse($this->user->hasRole($role1));
        $this->assertFalse($this->user->hasRole($role2));
    }

    public function testExchangeArrayNonRoles()
    {
        $data = array(
            'id'        => 'TestId',
            'username'  => 'TestUser',
            'email'     => 'TestEmail',
            'realname'  => 'TestRealName',
            'firstname' => 'TestFirstName',
            'surname'   => 'TestSurname',
            'password'  => 'Password',
            'locked'    => true,
            'suspended' => false
        );

        $this->user->exchangeArray($data);

        $this->assertEquals($data['id'],        $this->user->getId());
        $this->assertEquals($data['username'],  $this->user->getUsername());
        $this->assertEquals($data['email'],     $this->user->getEmail());
        $this->assertEquals($data['realname'],  $this->user->getRealname());
        $this->assertEquals($data['firstname'], $this->user->getFirstname());
        $this->assertEquals($data['surname'],   $this->user->getSurname());
        $this->assertEquals($data['password'],  $this->user->getPassword());
        $this->assertEquals($data['locked'],    $this->user->isLocked());
        $this->assertEquals($data['suspended'], $this->user->isSuspended());
    }

    public function testExchangeArrayRolesList()
    {
        $data = array(
            'roles' => ['TestRole1', 'TestRole2']
        );

        $this->assertFalse($this->user->hasRole('TestRole1'));
        $this->assertFalse($this->user->hasRole('TestRole2'));

        $this->user->exchangeArray($data);

        $this->assertTrue($this->user->hasRole('TestRole1'));
        $this->assertTrue($this->user->hasRole('TestRole2'));

    }

    public function testNoErrorMessages()
    {
        $this->assertEquals(
            array('errors' => array()),
            $this->user->getErrorMessages()
        );
    }

    public function testUsernameValidationSuccess()
    {
        $data = array(
            'username' => 'TestUser'
        );

        $this->user->exchangeArray($data);

        $this->assertTrue(
            $this->user->isValid(array('username'))
        );

        $this->assertEquals(
            array('errors' => array()),
            $this->user->getErrorMessages()
        );
    }

    public function testUsernameValidationRequiredFailureWithMessages()
    {
        $data = array(
            'username' => ''
        );

        $this->user->exchangeArray($data);

        $this->assertFalse(
            $this->user->isValid(array('username'))
        );

        $validationMessage = array(
            'errors' => array(
                'username' => array(
                    'isEmpty' => 'Value is required and can\'t be empty'
                )
            )
        );

        $this->assertEquals(
            $validationMessage,
            $this->user->getErrorMessages()
        );
    }

    public function testUsernameMinimumValidationFailureWithMessage()
    {
        $data = array(
            'username' => 'tu'
        );

        $this->user->exchangeArray($data);

        $this->assertFalse(
            $this->user->isValid(array('username'))
        );

        $validationMessage = array(
            'errors' => array(
                'username' => array(
                    'stringLengthTooShort' => "The input is less than 3 characters long"
                )
            )
        );

        $this->assertEquals(
            $validationMessage,
            $this->user->getErrorMessages()
        );
    }

    public function testUsernameMaximumValidationFailureWithMessage()
    {
        $data = array(
            'username' => str_pad('xyz', 255, 'abc')
        );

        $this->assertEquals(255, strlen($data['username']));

        $this->user->exchangeArray($data);

        $this->assertFalse(
            $this->user->isValid(array('username'))
        );

        $validationMessage = array(
            'errors' => array(
                'username' => array(
                    'stringLengthTooLong' => "The input is more than 128 characters long"
                )
            )
        );

        $this->assertEquals(
            $validationMessage,
            $this->user->getErrorMessages()
        );
    }

    private function createCaseItemCollection()
    {
        $caseItemCollection = new CaseItemCollection();

        for ($i = 0; $i < 10; $i++) {
            $lpa = new Lpa();
            $lpa->setCaseId($i);
            $caseItemCollection->addCaseItem($lpa);
        }

        return $caseItemCollection;
    }

    public function testGetSetCaseItemCollection()
    {
        $caseItemCollection = $this->createCaseItemCollection();

        $this->user->setCaseItemCollection($caseItemCollection);

        $this->assertSame($caseItemCollection, $this->user->getCaseItemCollection());
    }

    public function testGetArrayCopy()
    {
        $caseItemCollection = $this->createCaseItemCollection();

        $this->user->setCaseItemCollection($caseItemCollection);

        $array = $this->user->getArrayCopy();

        $expected = 10;
        $actual   = count($array['caseItemCollection']);

        $this->assertEquals(
            $expected,
            $actual
        );
    }


    public function testGetArrayCopyForRoles()
    {
        $this->assertFalse($this->user->hasRole('TestRole1'));
        $this->assertFalse($this->user->hasRole('TestRole2'));

        $this->user->addRole('TestRole1');
        $this->user->addRole('TestRole2');

        $this->assertTrue($this->user->hasRole('TestRole1'));
        $this->assertTrue($this->user->hasRole('TestRole2'));

        $array = $this->user->getArrayCopy();

        $expected = 2;
        $actual   = count($array['roles']);

        $this->assertEquals($expected, $actual);

        // Don't care about order so will use "in_array" instead of supplying an expected array
        $this->assertTrue(in_array('TestRole1', $array['roles']));
        $this->assertTrue(in_array('TestRole2', $array['roles']));
    }

    public function testDuplicateRoles() {
        $this->assertFalse($this->user->hasRole('TestRole1'));

        $this->user->addRole('TestRole1');
        $this->user->addRole('TestRole1');

        $this->assertTrue($this->user->hasRole('TestRole1'));

        $array = $this->user->getArrayCopy();

        $expected = 1;
        $actual   = count($array['roles']);

        $this->assertEquals($expected, $actual);

        $expectedArray = ['TestRole1'];
        $this->assertEquals($expectedArray, $array['roles']);
    }

    public function testRemovingRolesMultiple() {
        $this->assertFalse($this->user->hasRole('TestRole1'));

        $this->user->addRole('TestRole1');

        $this->user->removeRole('TestRole1');

        $this->assertFalse($this->user->hasRole('TestRole1'));

        // Remove the role again and make sure it's still gone and there are no errors.
        $this->user->removeRole('TestRole1');

        $this->assertFalse($this->user->hasRole('TestRole1'));
    }

    public function testToArray()
    {
        $caseArray = [
            ['id' => 'case1'],
            ['id' => 'case2']
        ];

        $caseItemCollectionMock = \Mockery::mock('Opg\Core\Model\Entity\CaseItem\CaseItemCollection');
        $caseItemCollectionMock->shouldReceive('toArray')
            ->andReturn($caseArray);

        $data = array(
            'id'        => 'TestId',
            'username'  => 'TestUser',
            'email'     => 'TestEmail',
            'realname'  => 'TestRealName',
            'firstname' => 'TestFirstName',
            'surname'   => 'TestSurname',
            'password'  => 'Password',
            'roles'     => ['TestRole1', 'TestRole2'],
            'locked'    => false,
            'suspended' => true
        );

        $this->user->exchangeArray($data);
        $this->user->setCaseItemCollection($caseItemCollectionMock);

        $this->assertEquals($data['id'],        $this->user->getId());
        $this->assertEquals($data['username'],  $this->user->getUsername());
        $this->assertEquals($data['email'],     $this->user->getEmail());
        $this->assertEquals($data['realname'],  $this->user->getRealname());
        $this->assertEquals($data['firstname'], $this->user->getFirstname());
        $this->assertEquals($data['surname'],   $this->user->getSurname());
        $this->assertEquals($data['password'],  $this->user->getPassword());
        $this->assertEquals($data['locked'],    $this->user->isLocked());
        $this->assertEquals($data['suspended'], $this->user->isSuspended());
        $this->assertTrue($this->user->hasRole('TestRole1'));
        $this->assertTrue($this->user->hasRole('TestRole2'));

        $userArray = $this->user->toArray();

        $this->assertTrue(is_array($userArray));

        $this->assertEquals('TestId',        $userArray['id']);
        $this->assertEquals('TestUser',      $userArray['username']);
        $this->assertEquals('TestEmail',     $userArray['email']);
        $this->assertEquals('TestRealName',  $userArray['realname']);
        $this->assertEquals('TestFirstName', $userArray['firstname']);
        $this->assertEquals('TestSurname',   $userArray['surname']);
        $this->assertEquals('Password',      $userArray['password']);
        $this->assertEquals(false,           $userArray['locked']);
        $this->assertEquals(true,            $userArray['suspended']);
        $this->assertEquals($caseArray,      $userArray['caseItemCollection']);
        $this->assertTrue(is_array($userArray['roles']));

        // Order not important/not guaranteed for roles so only check for presence of role names.
        $this->assertTrue(in_array('TestRole1', $userArray['roles']));
        $this->assertTrue(in_array('TestRole2', $userArray['roles']));
    }

    public function testIsSetLocked() {
        $this->assertEquals(null, $this->user->isLocked());

        $this->user->setLocked(true);
        $this->assertEquals(true, $this->user->isLocked());

        $this->user->setLocked(false);
        $this->assertEquals(false, $this->user->isLocked());

        $this->user->setLocked("string wot gets cast to bool true");
        $this->assertEquals(true, $this->user->isLocked());

        $this->user->setLocked(""); // string wot gets cast to bool false
        $this->assertEquals(false, $this->user->isLocked());

        $this->user->setLocked(5318008);
        $this->assertEquals(true, $this->user->isLocked());

        $this->user->setLocked(0);
        $this->assertEquals(false, $this->user->isLocked());

        $this->user->setLocked(-5318008);
        $this->assertEquals(true, $this->user->isLocked());
    }

    public function testIsSetSuspended() {
        $this->assertEquals(null, $this->user->isSuspended());

        $this->user->setSuspended(true);
        $this->assertEquals(true, $this->user->isSuspended());

        $this->user->setSuspended(false);
        $this->assertEquals(false, $this->user->isSuspended());

        $this->user->setSuspended("string wot gets cast to bool true");
        $this->assertEquals(true, $this->user->isSuspended());

        $this->user->setSuspended(""); // string wot gets cast to bool false
        $this->assertEquals(false, $this->user->isSuspended());

        $this->user->setSuspended(5318008);
        $this->assertEquals(true, $this->user->isSuspended());

        $this->user->setSuspended(0);
        $this->assertEquals(false, $this->user->isSuspended());

        $this->user->setSuspended(-5318008);
        $this->assertEquals(true, $this->user->isSuspended());
    }
}
