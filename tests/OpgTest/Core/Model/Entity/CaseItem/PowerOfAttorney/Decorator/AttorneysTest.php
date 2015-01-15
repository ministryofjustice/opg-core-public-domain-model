<?php

namespace OpgTest\Core\Model\Entity\CaseItem\PowerOfAttorney\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\Attorney;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Decorator\Attorneys;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Interfaces\HasAttorneys;

class AttorneysCollectionStub implements HasAttorneys
{
    use Attorneys;
}

class AttorneysTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AttorneysCollectionStub */
    protected $attorneys;

    public function setUp()
    {
        $this->attorneys = new AttorneysCollectionStub();
    }

    public function testSetUp()
    {
        $this->assertEmpty($this->attorneys->getAttorneys()->toArray());
    }

    public function testGetSetAttorneys()
    {
        $expected = new ArrayCollection();

        $this->assertEquals($this->attorneys->getAttorneys(), $expected);

        /** @var Attorney $attorney1 */
        $attorney1 = (new Attorney())->setId(1)->setFirstname('Attorney')->setSurname('One')->setDobString('01/01/1980');
        $attorney2 = (new Attorney())->setId(2)->setFirstname('Attorney')->setSurname('Two')->setDobString('01/01/1980');

        $expected->add($attorney1);
        $expected->add($attorney2);

        $this->assertTrue($this->attorneys->setAttorneys($expected) instanceof AttorneysCollectionStub);

        $this->assertCount(2, $this->attorneys->getAttorneys()->toArray());

        $this->assertEquals($expected, $this->attorneys->getAttorneys());
    }

    public function testRemoveAttorneys()
    {
        $expected = new ArrayCollection();

        $this->assertEquals($this->attorneys->getAttorneys(), $expected);

        /** @var Attorney $attorney1 */
        $attorney1 = (new Attorney())->setId(1)->setFirstname('Attorney')->setSurname('One')->setDobString('01/01/1980');
        $attorney2 = (new Attorney())->setId(2)->setFirstname('Attorney')->setSurname('Two')->setDobString('01/01/1980');
        $attorney3 = (new Attorney())->setId(3)->setFirstname('Attorney')->setSurname('Three')->setDobString('01/01/1980');


        $this->assertTrue($this->attorneys->addAttorney($attorney1) instanceof AttorneysCollectionStub);
        $this->assertTrue($this->attorneys->addAttorney($attorney2) instanceof AttorneysCollectionStub);
        $this->assertTrue($this->attorneys->addAttorney($attorney3) instanceof AttorneysCollectionStub);
        $this->assertTrue($this->attorneys->addAttorney($attorney3) instanceof AttorneysCollectionStub);

        $this->assertCount(3, $this->attorneys->getAttorneys()->toArray());

        $this->assertTrue($this->attorneys->removeAttorney($attorney1) instanceof AttorneysCollectionStub);

        $this->assertCount(2, $this->attorneys->getAttorneys()->toArray());
    }

    public function testFindAttorneys()
    {
        $expected = new ArrayCollection();

        $this->assertEquals($this->attorneys->getAttorneys(), $expected);

        /** @var Attorney $attorney1 */
        $attorney1 = (new Attorney())->setId(1)->setFirstname('Attorney')->setSurname('One')->setDobString('01/01/1980');
        $attorney2 = (new Attorney())->setId(2)->setFirstname('Attorney')->setSurname('Two')->setDobString('01/01/1980');
        $attorney3 = (new Attorney())->setId(3)->setFirstname('Attorney')->setSurname('Three')->setDobString('01/01/1980');
        $attorney4 = (new Attorney())->setId(4)->setFirstname('Attorney')->setSurname('Four')->setDobString('01/01/1980');
        $attorney5 = (new Attorney())->setId(5)->setFirstname('Attorney')->setSurname('Five')->setDobString('01/01/1980');
        $attorney6 = (new Attorney())->setId(6)->setFirstname('Attorney')->setSurname('Five');


        $this->assertTrue($this->attorneys->addAttorney($attorney1) instanceof AttorneysCollectionStub);
        $this->assertTrue($this->attorneys->addAttorney($attorney2) instanceof AttorneysCollectionStub);
        $this->assertTrue($this->attorneys->addAttorney($attorney3) instanceof AttorneysCollectionStub);
        $this->assertTrue($this->attorneys->addAttorney($attorney3) instanceof AttorneysCollectionStub);

        $this->assertCount(3, $this->attorneys->getAttorneys()->toArray());

        $this->assertEmpty($this->attorneys->findAttorney($attorney4)->toArray());
        $this->assertCount(1, $this->attorneys->findAttorney($attorney1)->toArray());

        $this->assertTrue($this->attorneys->addAttorney($attorney5) instanceof AttorneysCollectionStub);

        $this->assertCount(1, $this->attorneys->findAttorney($attorney6)->toArray());
    }
}
