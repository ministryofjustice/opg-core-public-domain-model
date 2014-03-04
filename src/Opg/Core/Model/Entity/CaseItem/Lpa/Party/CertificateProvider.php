<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Traits\Party;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Person;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 *
 * @package Opg Domain Model
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class CertificateProvider implements PartyInterface
{
    use Party;
    use Person;
    use ToArray;
    
    /**
     * @var string
     */
    private $certificateProviderStatementType;
    
    /**
     * @var string
     */
    private $statement;
    
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
}
