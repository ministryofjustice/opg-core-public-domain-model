<?php
namespace OpgTest\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Assignable\User;
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

    public function testNoErrorMessages()
    {
        $this->assertEquals(
            array('errors' => array()),
            $this->user->getErrorMessages()
        );
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

        $expectedArray = ['TestRole1' => 'TestRole1'];
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
        $this->assertTrue($this->user->setSuspended(true)->isSuspended());
        $this->assertFalse($this->user->setSuspended(false)->isSuspended());
    }

    public function testGetSetLocked()
    {
        $this->assertTrue($this->user->setLocked(true)->isLocked());
        $this->assertFalse($this->user->setLocked(false)->isLocked());
    }

    public function testSetGetNormalisedRoles()
    {
        $roles = array('guest', 'user', 'junior-admin');
        $this->user->setFromNormalisedRoles($roles);

        $this->assertEquals($roles, $this->user->getNormalisedRoles());

        $this->user->setRoles($this->user->getRoles());

        $this->assertEquals($roles, $this->user->getNormalisedRoles());
    }

    public function testSetGetPowerOfAttorneys()
    {
        $poaCollection = new ArrayCollection();

        for ($count = 1; $count <= 5; $count++ ) {
            $poa = new Lpa();
            $poa->setId($count);
            $poaCollection->add($poa);
        }

        $this->user->setPowerOfAttorneys($poaCollection);

        $this->assertEquals($poaCollection, $this->user->getPowerOfAttorneys());

    }

    public function testSetGetDeputyShips()
    {
        $deputyCollection = new ArrayCollection();

        for ($count = 1; $count <= 5; $count++ ) {
            $dep = $this->getMockForAbstractClass('Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship');
            $dep->setId($count);
            $deputyCollection->add($dep);
        }

        $this->user->setDeputyships($deputyCollection);

        $this->assertEquals($deputyCollection, $this->user->getDeputyships());

    }

    public function testDefaultRoleRequirementsFailMissing() {
        $this->assertFalse($this->user->isValid(array('roles')));
    }

    public function testDefaultRoleRequirementsFailBoth() {
        $this->user->addRole('OPG User');
        $this->user->addRole('COP User');
        $this->assertFalse($this->user->isValid(array('roles')));
    }

    public function testDefaultRoleRequirementsPassOPG() {
        $this->user->addRole('OPG User');
        $this->assertTrue($this->user->isValid(array('roles')));
    }

    public function testDefaultRoleRequirementsPassCOP() {
        $this->user->addRole('COP User');
        $this->assertTrue($this->user->isValid(array('roles')));
    }

    public function testBlankRoleFail() {
        $this->user->addRole('COP User');
        $this->assertTrue($this->user->isValid(array('roles')));

        $this->user->addRole('');
        $this->assertFalse($this->user->isValid(array('roles')));
    }

    public function testGetDisplayName()
    {
        $firstName = 'Test';
        $surname = 'User';

        $expected = sprintf('%s %s', $firstName, $surname);

        $this->user->setFirstname($firstName)->setSurname($surname);

        $this->assertEquals($expected, $this->user->getDisplayName());
    }
}
