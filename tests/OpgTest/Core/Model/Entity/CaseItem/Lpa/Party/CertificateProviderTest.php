<?php
namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;

class CertificateProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CertificateProvider
     */
    private $certificateProvider;

    public function setUp()
    {
        $this->certificateProvider = new CertificateProvider();
    }

    public function testSetGetStatementType()
    {
        $expected = 'They have known me for a long time';

        $this->certificateProvider->setCertificateProviderStatementType($expected);

        $this->assertEquals(
            $expected,
            $this->certificateProvider->getCertificateProviderStatementType()
        );
    }

    public function testSetGetStatement()
    {
        $expected = 'I have known the donor for a long time';

        $this->certificateProvider->setStatement($expected);

        $this->assertEquals(
            $expected,
            $this->certificateProvider->getStatement()
        );
    }

    public function testGetSetRelationshipToDonor()
    {
        $expectedRelationship = 'Doctor';
        $this->certificateProvider->setRelationshipToDonor($expectedRelationship);
        $this->assertEquals($expectedRelationship, $this->certificateProvider->getRelationshipToDonor());
    }

    public function testGetSetCertificateProviderSkills()
    {
        $expected = 'Medically trained';

        $this->assertEmpty($this->certificateProvider->getCertificateProviderSkills());

        $this->certificateProvider->setCertificateProviderSkills($expected);
        $this->assertEquals($expected, $this->certificateProvider->getCertificateProviderSkills());
    }
}
