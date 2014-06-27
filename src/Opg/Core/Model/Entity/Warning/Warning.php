<?php

namespace Opg\Core\Model\Entity\Warning;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Common\Model\Entity\HasSystemStatusInterface;
use Opg\Common\Model\Entity\Traits\HasSystemStatus;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\User\User as UserEntity;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ReadOnly;

/**
 * Class Warning
 * @package Opg\Core\Model\Entity\Warning
 *
 * @ORM\Entity
 * @ORM\Table(name = "warning")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class Warning implements HasSystemStatusInterface
{
    use HasSystemStatus;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $warningType;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    protected $warningText;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDateAddedString", setter="setDateAddedString")
     * @Type("string")
     * @ReadOnly
     */
    protected $dateAdded;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDateClosedString", setter="setDateClosedString")
     * @Type("string")
     */
    protected $dateClosed;

    /**
     * @ORM\OneToOne(targetEntity="Opg\Core\Model\Entity\User\User")
     * @ORM\JoinColumn(name="added_by", references="id")
     * @var UserEntity
     */
    protected $addedBy;

    /**
     * @ORM\OneToOne(targetEntity="Opg\Core\Model\Entity\User\User")
     * @ORM\JoinColumn(name="closed_by", references="id")
     * @var UserEntity
     */
    protected $closedBy;

    public function __construct()
    {
        $this->dateAdded = new \DateTime();
    }

    /**
     * @param \Opg\Core\Model\Entity\User\User $addedBy
     *
     * @return Warning
     */
    public function setAddedBy(UserEntity $addedBy)
    {
        $this->addedBy = $addedBy;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\User\User
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param \Opg\Core\Model\Entity\User\User $closedBy
     *
     * @return Warning
     */
    public function setClosedBy(UserEntity $closedBy)
    {
        $this->closedBy = $closedBy;

        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\User\User
     */
    public function getClosedBy()
    {
        return $this->closedBy;
    }

    /**
     * @param \DateTime $dateAdded
     *
     * @return Warning
     */
    public function setDateAdded(\DateTime $dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }


    /**
     * @param string $dateAdded
     * @return Warning
     */
    public function setDateAddedString($dateAdded)
    {
        if (!empty($dateAdded)) {
            return $this->setDateAdded(DateFormat::createDateTime($dateAdded));
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @return string
     */
    public function getDateAddedString()
    {
        if (!empty($this->dateAdded)) {
            return $this->getDateAdded()->format(DateFormat::getDateFormat());
        }
        // @codeCoverageIgnoreStart
        return '';
        //@codeCoverageIgnoreEnd
    }

    /**
     * @param \DateTime $dateClosed
     *
     * @return Warning
     */
    public function setDateClosed(\DateTime $dateClosed)
    {
        $this->dateClosed = $dateClosed;

        return $this;
    }

    /**
     * @param $dateClosed
     *
     * @return Warning
     */
    public function setDateClosedString($dateClosed)
    {
        if (!empty($dateClosed)) {
            return $this->setDateClosed(DateFormat::createDateTime($dateClosed));
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateClosed()
    {
        return $this->dateClosed;
    }

    /**
     * @return string
     */
    public function getDateClosedString()
    {
        if (!empty($this->dateClosed)) {
            return $this->getDateClosed()->format(DateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param int $id
     *
     * @return Warning
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $warningText
     *
     * @return Warning
     */
    public function setWarningText($warningText)
    {
        $this->warningText = $warningText;

        return $this;
    }

    /**
     * @return string
     */
    public function getWarningText()
    {
        return $this->warningText;
    }

    /**
     * @param string $warningType
     *
     * @return Warning
     */
    public function setWarningType($warningType)
    {
        $this->warningType = $warningType;

        return $this;
    }

    /**
     * @return string
     */
    public function getWarningType()
    {
        return $this->warningType;
    }


}
