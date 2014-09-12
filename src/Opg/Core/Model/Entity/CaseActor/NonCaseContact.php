<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItemInterface;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * Class NoneCaseContact
 * @package Opg\Core\Model\Entity\CaseActor
 */
class NonCaseContact extends BasePerson
{
    use ToArray;

    /**
     * @var ArrayCollection
     * @ReadOnly
     * @Exclude
     */
    protected $powerOfAttorneys = null;

    /**
     * @var ArrayCollection
     * @ReadOnly
     * @Exclude
     */
    protected $deputyships = null;
    
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $fullname = null;

    public function __construct()
    {
        parent::__construct();
        $this->powerOfAttorneys = null;
        $this->deputyships = null;
    }

    /**
     * @param ArrayCollection $cases
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface|void
     * @throws \LogicException
     */
    public function setCases(ArrayCollection $cases)
    {
        throw new \LogicException('Non case contacts cannot have cases assigned to them');
    }

    /**
     * @param CaseItemInterface $case
     * @return BasePerson|void
     * @throws \LogicException
     */
    public function addCase(CaseItemInterface $case)
    {
        throw new \LogicException('Non case contacts cannot have cases assigned to them');
    }

    /**
     * @return array|null
     */
    public function getCases()
    {
        return null;
    }

    /**
     *
     * @return string $fullname
     */
    public function getFullname()
    {
        if(empty($this->fullname) && (!empty($this->surname)||!empty($this->firstname)||!empty($this->middlenames))) {
            $this->fullname = implode(' ', array($this->firstname, $this->middlenames, $this->surname));
        }
        
        return $this->fullname;
    }

    /**
     *
     * @param  string $fullname
     *
     * @return PartyInterface
     */
    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
        
        if($fullname != null) {
            $names = explode(' ', $fullname);
            
            $no_of_words_in_fullname = sizeof($names);
            if($no_of_words_in_fullname > 1) {
                $this->firstname = $names[0];
                $this->surname = $names[$no_of_words_in_fullname-1];
                
                if($no_of_words_in_fullname > 2) {
                    array_shift($names);
                    array_pop($names);
                    $this->middlenames = implode(' ', $names);
                }
            }
            else {
                $this->surname = $names[0];
            }
        }

        return $this;
    }
}
