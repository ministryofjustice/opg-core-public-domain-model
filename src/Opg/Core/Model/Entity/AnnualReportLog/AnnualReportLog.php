<?php
namespace Opg\Core\Model\Entity\AnnualReportLog;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Order;
use Zend\InputFilter\Factory as InputFactory;


/**
 * @ORM\Entity
 * @ORM\Table(name = "annual_report_logs")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @package Opg Core
 */
class AnnualReportLog implements EntityInterface, \IteratorAggregate, HasIdInterface
{
    use \Opg\Common\Model\Entity\Traits\IteratorAggregate;
    use ToArray;
    use HasId;
    use InputFilter;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\CaseItem\Deputyship\Order")
     * @ORM\JoinColumn(nullable = false)
     * @var Order $deputyshipOrder
     */
    protected $deputyshipOrder;

    /**
     * @ORM\Column(type = "date")
     * @var string $dueDate
     */
    protected $dueDate;

    /**
     * @ORM\Column(type = "date")
     * @var string $reportingPeriodEndDate
     */
    protected $reportingPeriodEndDate;

    /**
     * @ORM\Column(type = "date", nullable = true)
     * @var string $revisedDueDate
     */
    protected $revisedDueDate;

    /**
     * @ORM\Column(type = "integer")
     * @var string $numberOfChaseLetters
     */
    protected $numberOfChaseLetters = 0;

    /**
     * @ORM\OneToOne(targetEntity="Opg\Core\Model\Entity\Document\LodgingChecklist")
     * @var string $lodgingChecklistDocument
     */
    protected $lodgingChecklistDocument;

    /**
     * @ORM\OneToOne(targetEntity="Opg\Core\Model\Entity\Document\AnnualReport")
     * @var string $annualReportDocument
     */
    protected $annualReportDocument;

    /**
     * @param Order $deputyshipOrder
     * @return AnnualReportLog
     */
    public function setDeputyshipOrder(Order $deputyshipOrder)
    {
        $this->deputyshipOrder = $deputyshipOrder;

        return $this;
    }

    /**
     * @return Order
     */
    public function getDeputyshipOrder()
    {
        return $this->deputyshipOrder;
    }

    /**
     * @param \DateTime $dueDate
     * @return AnnualReportLog
     */
    public function setDueDate(\DateTime $dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $reportingPeriodEndDate
     * @return AnnualReportLog
     */
    public function setReportingPeriodEndDate(\DateTime $reportingPeriodEndDate)
    {
        $this->reportingPeriodEndDate = $reportingPeriodEndDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getReportingPeriodEndDate()
    {
        return $this->reportingPeriodEndDate;
    }

    /**
     * @param \DateTime $revisedDueDate
     * @return AnnualReportLog
     */
    public function setRevisedDueDate(\DateTime $revisedDueDate = null)
    {
        $this->revisedDueDate = $revisedDueDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRevisedDueDate()
    {
        return $this->revisedDueDate;
    }

    /**
     * @param $numberOfChaseLetters
     * @return AnnualReportLog
     */
    public function setNumberOfChaseLetters($numberOfChaseLetters)
    {
        $this->numberOfChaseLetters = $numberOfChaseLetters;

        return $this;
    }

    public function getNumberOfChaseLetters()
    {
        return $this->numberOfChaseLetters;
    }

    public function getLodgingDate()
    {
        // To be implemented when Lodging Checklist association is implemented.
        return '';
    }

    public function getReceivedDate()
    {
        // To be implemented when Annual Report association is implemented.
        return '';
    }

    /**
     * @throws \Opg\Common\Exception\UnusedException
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name' => 'deputyshipOrder',
                        'required' => true,
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'dueDate',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Date',
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'reportingPeriodEndDate',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Date',
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'revisedDueDate',
                        'required'  => false,
                        'validators' => array(
                            array(
                                'name'    => 'Date',
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'numberOfChaseLetters',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Int',
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
