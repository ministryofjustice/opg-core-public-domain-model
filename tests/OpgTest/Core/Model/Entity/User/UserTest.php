<?php
namespace OpgTest\Core\Model\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\User\User;
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

        $this->assertEquals(array($role1 => $role1, $role2 => $role2), $this->user->getRoles());

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
            'firstname' => 'TestFirstName',
            'surname'   => 'TestSurname',
            'password'  => 'Password',
            'locked'    => true,
            'suspended' => false
        );

        $this->user->exchangeArray($data);

        $this->assertEquals($data['id'],        $this->user->getId());
        $this->assertEquals($data['email'],     $this->user->getEmail());
        $this->assertEquals($data['firstname'], $this->user->getFirstname());
        $this->assertEquals($data['surname'],   $this->user->getSurname());
        $this->assertEquals($data['password'],  $this->user->getPassword());
        $this->assertEquals($data['locked'],    $this->user->isLocked());
        $this->assertEquals($data['suspended'], $this->user->isSuspended());
    }

    public function testExchangeArrayRolesList()
    {
        $data = array(
            'roles' => array(
                'TestRole1' => 'TestRole1',
                'TestRole2' => 'TestRole2'
            )
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

    private function createCaseItemCollection()
    {
        $caseItemCollection = new ArrayCollection();

        for ($i = 0; $i < 10; $i++) {
            $lpa = new Lpa();
            $lpa->setId($i);
            $caseItemCollection->add($lpa);
        }

        return $caseItemCollection;
    }

    public function testToArrayForRoles()
    {
        $this->assertFalse($this->user->hasRole('TestRole1'));
        $this->assertFalse($this->user->hasRole('TestRole2'));

        $this->user->addRole('TestRole1');
        $this->user->addRole('TestRole2');

        $this->assertTrue($this->user->hasRole('TestRole1'));
        $this->assertTrue($this->user->hasRole('TestRole2'));

        $array = $this->user->toArray();

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

        $array = $this->user->toArray();

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
        $data = array(
            'id'        => 'TestId',
            'email'     => 'TestEmail',
            'firstname' => 'TestFirstName',
            'surname'   => 'TestSurname',
            'password'  => 'Password',
            'roles' => array(
                'TestRole1' => 'TestRole1',
                'TestRole2' => 'TestRole2'
            ),
            'locked'    => false,
            'suspended' => false
        );

        $this->user->exchangeArray($data);

        $this->assertEquals($data['id'],        $this->user->getId());
        $this->assertEquals($data['email'],     $this->user->getEmail());
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
        $this->assertEquals('TestEmail',     $userArray['email']);
        $this->assertEquals('TestFirstName', $userArray['firstname']);
        $this->assertEquals('TestSurname',   $userArray['surname']);
        $this->assertEquals('Password',      $userArray['password']);

        // Order not important/not guaranteed for roles so only check for presence of role names.
        $this->assertTrue(in_array('TestRole1', $userArray['roles']));
        $this->assertTrue(in_array('TestRole2', $userArray['roles']));
    }

    public function testCreateUserFail()
    {
       $this->assertFalse($this->user->isValid());
        $messages = $this->user->getInputFilter()->getMessages();
        $this->assertNotEmpty($messages);

        $this->assertArrayHasKey('firstname', $messages);
        $this->assertArrayHasKey('surname', $messages);
        $this->assertArrayHasKey('email', $messages);
        $this->assertArrayHasKey('password', $messages);

    }

    public function testCreateUserPass()
    {
        $expectedFirstname = 'First';
        $expectedSurname = 'Surname';
        $expectedEmail = 'user@domain.com';
        $expectedPassword = substr(md5('password'), 0,12);

        $this->user->setFirstname($expectedFirstname)
            ->setSurname($expectedSurname)
            ->setEmail($expectedEmail)
            ->setPassword($expectedPassword);

        $this->assertTrue($this->user->isValid(array('firstname', 'surname', 'email', 'password')));
        $messages = $this->user->getInputFilter()->getMessages();
        $this->assertEmpty($messages);
    }

    public function testGetSetSuspended()
    {
        $this->assertTrue($this->user->setSuspended(true)->getSuspended());
        $this->assertFalse($this->user->setSuspended(false)->getSuspended());
    }

    public function testGetSetLocked()
    {
        $this->assertTrue($this->user->setLocked(true)->getLocked());
        $this->assertFalse($this->user->setLocked(false)->getLocked());
    }
}
