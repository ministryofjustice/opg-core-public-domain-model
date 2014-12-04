<?php
namespace Opg\Core\Model\Entity\CaseItem\Deputyship;

use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\CaseActor\Client;
use Opg\Core\Model\Entity\CaseActor\Deputy;
use Opg\Core\Model\Entity\CaseActor\FeePayer;
use Opg\Core\Model\Entity\CaseActor\Person;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasCourtFunds;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasCourtFundsInterface;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\OrderFilter;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;

/**
 * @ORM\Entity
 */
class Order extends Deputyship implements HasCourtFundsInterface
{
    use HasCourtFunds;

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseActor\FeePayer", fetch = "EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var FeePayer
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @ReadOnly
     */
    protected $feePayer;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $fileLocationDescription;

    /**
     * @ORM\OneToOne(targetEntity="Opg\Core\Model\Entity\Address\Address")
     * @ORM\JoinColumn(name="filelocation_id", referencedColumnName="id")
     * @var Address
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $fileLocationAddress;

    /**
     * @param Person $person
     * @return CaseItem
     * @throws \LogicException
     */
    public function addPerson(Person $person)
    {
        switch ($person) {
            case $person instanceof Client:
                $this->setClient($person);
                break;
            case $person instanceof Deputy:
                $this->addDeputy($person);
                break;
            case $person instanceof FeePayer:
                $this->setFeePayer($person);
                break;
            default :
                throw new \LogicException('The person type of ' . get_class($person) . ' is not supported by ' .  get_class($this));
        }

        return $this;
    }

    /**
     * @param mixed $feePayer
     * @return Order
     */
    public function setFeePayer(FeePayer $feePayer)
    {
        $this->feePayer = $feePayer;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeePayer()
    {
        return $this->feePayer;
    }

    /**
     * @return \Opg\Common\Filter\BaseInputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = parent::getInputFilter();
            $this->inputFilter->merge(new OrderFilter());
        }

        return $this->inputFilter;
    }
}
