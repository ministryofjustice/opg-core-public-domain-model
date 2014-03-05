<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class CertificateProvider extends BasePerson implements PartyInterface, EntityInterface
{
    use ToArray {
        toArray as toTraitArray;
    }
    use ExchangeArray;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $certificateProviderStatementType;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $statement;

    /**
     * @return string $certificateProviderStatementType
     */
    public function getCertificateProviderStatementType()
    {
        return $this->certificateProviderStatementType;
    }

    /**
     * @param string $certificateProviderStatementType
     * @return CertificateProvider
     */
    public function setCertificateProviderStatementType(
        $certificateProviderStatementType
    ) {
        $this->certificateProviderStatementType = $certificateProviderStatementType;
        return $this;
    }

    /**
     * @return string $statement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param string $statement
     * @return CertificateProvider
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;
        return $this;
    }

    /**
     * @return void|InputFilterInterface
     * @throws \Opg\Common\Exception\UnusedException
     */
    public function getInputFilter()
    {
        throw new UnusedException();
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new UnusedException();
    }

    /**
     * @param bool $exposeClassName
     *
     * @return array
     */
    public function toArray($exposeClassName = TRUE)
    {
        return $this->toTraitArray($exposeClassName);
    }
}
