<?php
namespace OpgTest\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantFactory;

class ApplicantFactoryTest extends \PHPUnit_Framework_TestCase
{
    protected function buildApplicant(array $data)
    {
        return ApplicantFactory::createApplicant($data);
    }

    public function testCreateUnknownType()
    {
        $builderArray = array('certificateProviderStatementType'=>NULL);
        try {
            $this->buildApplicant($builderArray);
        }
        catch(\Exception $e) {
            $this->assertEquals($e->getMessage(), "Cannot build unknown person type.");
        }
    }
    public function testCreateDonor()
    {
        $builderArray = array('className'=> "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Donor");
        $applicant = $this->buildApplicant($builderArray);
        $this->assertTrue($applicant instanceof Donor);
        $this->assertTrue($applicant instanceof PartyInterface);
        $this->assertTrue($applicant instanceof EntityInterface);
        $this->assertTrue(in_array('toArray',get_class_methods(get_class($applicant))));
        $this->assertTrue(in_array('exchangeArray',get_class_methods(get_class($applicant))));
    }

    public function testCreateAttorney()
    {
        $builderArray = array('className'=> "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Attorney");
        $applicant = $this->buildApplicant($builderArray);
        $this->assertTrue($applicant instanceof Attorney);
        $this->assertTrue($applicant instanceof PartyInterface);
        $this->assertTrue($applicant instanceof EntityInterface);
        $this->assertTrue(in_array('toArray',get_class_methods(get_class($applicant))));
        $this->assertTrue(in_array('exchangeArray',get_class_methods(get_class($applicant))));
    }

    public function testCreateCertificateProvider()
    {
        $builderArray = array('className'=> "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\CertificateProvider");
        $applicant = $this->buildApplicant($builderArray);
        $this->assertTrue($applicant instanceof CertificateProvider);
        $this->assertTrue($applicant instanceof PartyInterface);
        $this->assertTrue($applicant instanceof EntityInterface);
        $this->assertTrue(in_array('toArray',get_class_methods(get_class($applicant))));
        $this->assertTrue(in_array('exchangeArray',get_class_methods(get_class($applicant))));
    }

    public function testCreateNotifiedPerson()
    {
        $builderArray = array('className'=> "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\NotifiedPerson");
        $applicant = $this->buildApplicant($builderArray);
        $this->assertTrue($applicant instanceof NotifiedPerson);
        $this->assertTrue($applicant instanceof PartyInterface);
        $this->assertTrue($applicant instanceof EntityInterface);
        $this->assertTrue(in_array('toArray',get_class_methods(get_class($applicant))));
        $this->assertTrue(in_array('exchangeArray',get_class_methods(get_class($applicant))));
    }

    public function testCreateCorrespondent()
    {
        $builderArray = array('className'=> "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Correspondent");
        $applicant = $this->buildApplicant($builderArray);
        $this->assertTrue($applicant instanceof Correspondent);
        $this->assertTrue($applicant instanceof PartyInterface);
        $this->assertTrue($applicant instanceof EntityInterface);
        $this->assertTrue(in_array('toArray',get_class_methods(get_class($applicant))));
        $this->assertTrue(in_array('exchangeArray',get_class_methods(get_class($applicant))));
    }

    public function testCreateEmptyClassName()
    {
        $builderArray = array('className'=> 'randomclass');
        $applicant = $this->buildApplicant($builderArray);
        $this->assertTrue($applicant instanceof Correspondent);
        $this->assertTrue($applicant instanceof PartyInterface);
        $this->assertTrue($applicant instanceof EntityInterface);
        $this->assertTrue(in_array('toArray',get_class_methods(get_class($applicant))));
        $this->assertTrue(in_array('exchangeArray',get_class_methods(get_class($applicant))));
    }
}

