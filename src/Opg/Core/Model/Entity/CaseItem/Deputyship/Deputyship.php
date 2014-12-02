<?php
namespace Opg\Core\Model\Entity\CaseItem\Deputyship;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\HasStatusDate;
use Opg\Common\Model\Entity\Traits\StatusDate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Core\Model\Entity\CaseActor\Client;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 */
abstract class Deputyship extends CaseItem implements HasStatusDate
{
    use StatusDate;

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseActor\Client", fetch = "EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var Client
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @ReadOnly
     */
    protected $client;

    /**
     * @var ArrayCollection
     */
    protected $deputies;

    protected $securityBond = false;

    protected $bondReferenceNumber;

    protected $bondValue;



    /**
     * @return \Opg\Common\Filter\BaseInputFilter
     */
    public function getInputFilter()
    {
       if (!$this->inputFilter) {
           $this->inputFilter = parent::getInputFilter();
       }

        return $this->inputFilter;
    }
}
