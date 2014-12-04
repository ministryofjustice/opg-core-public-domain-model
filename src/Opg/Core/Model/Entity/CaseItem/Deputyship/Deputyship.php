<?php
namespace Opg\Core\Model\Entity\CaseItem\Deputyship;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Common\Model\Entity\HasStatusDate;
use Opg\Common\Model\Entity\Traits\StatusDate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Core\Model\Entity\CaseActor\Client;
use Opg\Core\Model\Entity\CaseActor\Decorators\CaseRecNumber;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasCaseRecNumber;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasAnnualReports;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasDeputies;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasDeputiesInterface;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasFees;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator\HasFeesInterface;

/**
 * @ORM\Entity
 */
abstract class Deputyship extends CaseItem implements HasStatusDate, HasCaseRecNumber, HasFeesInterface, HasDeputiesInterface
{
    use StatusDate;
    use CaseRecNumber;
    use HasFees;
    use HasDeputies;
    use HasAnnualReports;

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseActor\Client", fetch = "EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var Client
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @ReadOnly
     */
    protected $client;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="orderDate")
     * @Type("string")
     */
    protected $orderDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="orderIssueDate")
     * @Type("string")
     */
    protected $orderIssueDate;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $securityBond = false;

    /**
     * @ORM\Column(type="string")
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $bondReferenceNumber;

    /**
     * @ORM\Column(type="float")
     * @var float
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $bondValue;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $orderStatus;

    /**
     * @param string $bondReferenceNumber
     * @return Deputyship
     */
    public function setBondReferenceNumber($bondReferenceNumber)
    {
        $this->bondReferenceNumber = $bondReferenceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getBondReferenceNumber()
    {
        return $this->bondReferenceNumber;
    }

    /**
     * @param float $bondValue
     * @return Deputyship
     */
    public function setBondValue($bondValue)
    {
        $this->bondValue = (float)$bondValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getBondValue()
    {
        return $this->bondValue;
    }

    /**
     * @param \DateTime $orderDate
     * @return Deputyship
     */
    public function setOrderDate(\DateTime $orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @param \DateTime $orderIssueDate
     * @return Deputyship
     */
    public function setOrderIssueDate(\DateTime $orderIssueDate)
    {
        $this->orderIssueDate = $orderIssueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getOrderIssueDate()
    {
        return $this->orderIssueDate;
    }

    /**
     * @param string $orderStatus
     * @return Deputyship
     */
    public function setOrderStatus($orderStatus)
    {
        $this->orderStatus = $orderStatus;

        return $this;
    }

    /**
     * @return string
     */
    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    /**
     * @param boolean $securityBond
     * @return Deputyship
     */
    public function setSecurityBond($securityBond)
    {
        $this->securityBond = (bool)$securityBond;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getSecurityBond()
    {
        return $this->securityBond;
    }

    /**
     * @return bool
     */
    public function hasSecurityBond()
    {
        return (true === $this->getSecurityBond());
    }

    /**
     * @param Client $client
     * @return Deputyship
     * @throws \LogicException
     */
    public function setClient(Client $client)
    {
        if (null === $this->client) {
            $this->client = $client;
        }
        else {
            throw new \LogicException('This case already has an attached client');
        }

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseActor\Client
     */
    public function getClient()
    {
        return $this->client;
    }


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
