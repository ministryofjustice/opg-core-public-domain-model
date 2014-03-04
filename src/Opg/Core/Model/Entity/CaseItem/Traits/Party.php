<?php

/**
 * @package Opg Core Domain Model
 */

namespace Opg\Core\Model\Entity\CaseItem\Traits;

use Opg\Core\Model\Entity\CaseItem\CaseItemCollection;
use Opg\Core\Model\Entity\CaseItem\CaseItemInterface;

trait Party {

    /**
     * @var string
     */
    private $id;
    
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var CaseItemCollection
     */
    private $caseCollection = null;
    
    /**
     * @param CaseItemInterface
     * @return PartyInterface
     */
    public function addCase(CaseItemInterface $case)
    {
        if ($this->caseCollection == null) {
            $this->caseCollection = new CaseItemCollection();
        }
        
        $this->caseCollection->addCaseItem($case);
    }
    
    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     * @return PartyInterface
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    
    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @param string $id
     * @return PartyInterface
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return CaseItemCollection $cases
     */
    public function getCases()
    {
        if ($this->caseCollection == null) {
            $this->caseCollection = new CaseItemCollection();
        }
        
        return $this->caseCollection;
    }
    
    /**
     * @param CaseItemCollection $cases
     * @return PartyInterface
     */
    public function setCases(CaseItemCollection $cases)
    {
        $this->caseCollection = $cases;
        return $this;
    }
}
