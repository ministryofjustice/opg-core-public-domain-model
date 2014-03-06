<?php

namespace OpgTest\Core\Model\Entity\PowerOfAttorney;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorneyFactory;

class PowerOfAttorneyTest extends \PHPUnit_Framework_TestCase {

    protected $poa;

    public function setUp()
    {
        $this->poa = $this->getMockForAbstractClass('Opg\\Core\\Model\\Entity\\PowerOfAttorney\\PowerOfAttorney');
    }

    public function testSetUp()
    {
        $this->assertTrue($this->poa instanceof PowerOfAttorney);
    }

    public function testGetSetAttorneys()
    {
        $attorneys = $this->poa->getAttorneys();

        for($i=0;$i<5;$i++) {
            $attorneys->add(new Attorney());
        }

        $this->poa->setAttorneys($attorneys);

        $this->assertEquals($attorneys, $this->poa->getAttorneys());
    }

    public function testGetSetNotifiedPersons()
    {
        $notfiedPersons = $this->poa->getNotifiedPersons();

        for($i=0;$i<5;$i++) {
            $notfiedPersons->add(new NotifiedPerson());
        }

        $this->poa->setNotifiedPersons($notfiedPersons);

        $this->assertEquals($notfiedPersons, $this->poa->getNotifiedPersons());

    }

    public function testGetSetCertificateProviders()
    {
        $certificateProviders = $this->poa->getCertificateProviders();

        for($i=0;$i<5;$i++) {
            $certificateProviders->add(new CertificateProvider());
        }

        $this->poa->setCertificateProviders($certificateProviders);

        $this->assertEquals($certificateProviders, $this->poa->getCertificateProviders());

    }

    public function testFilterThrowsAnError()
    {
        $this->poa->addApplicant(ApplicantFactory::createApplicant(array('className'=>'Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Donor')));
        $this->poa->isValid();

        $this->assertNotEmpty($this->poa->getInputFilter()->getMessages());
        $this->assertEquals(1, count($this->poa->getInputFilter()->getMessages()['caseItems']));
    }
}
