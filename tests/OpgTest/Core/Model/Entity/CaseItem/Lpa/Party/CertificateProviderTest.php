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

    public function testToArrayExchangeArray()
    {
        $this->certificateProvider
            ->setId('1')
            ->setEmail('certificateprovider@domain.com')
            ->setCases(new ArrayCollection());


        $certificateProvider = $this->certificateProvider->toArray();

        $certificateProvider2 = $this->certificateProvider->exchangeArray($certificateProvider);

        $this->assertArrayHasKey('className',$certificateProvider);
        $this->assertEquals(get_class($certificateProvider2), $certificateProvider['className']);
        $this->assertEquals($this->certificateProvider, $certificateProvider2);
        $this->assertEquals($certificateProvider, $certificateProvider2->toArray());
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
