<?php
namespace Opg\Core\Model\Entity\CaseItem\Epa;

use Opg\Core\Model\Entity\CaseActor\PersonNotifyDonor;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseActor\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseActor\Correspondent;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseActor\NotifiedRelative;
use Opg\Core\Model\Entity\CaseActor\NotifiedAttorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\CaseType as CaseTypeValidator;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\GenericAccessor;

/**
 * @ORM\Entity
 *
 * Class Epa
 *
 * @package Opg Core
 */
class Epa extends PowerOfAttorney
{

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups("api-task-list")
     */
    protected $caseType = CaseTypeValidator::CASE_TYPE_EPA;

    /**
     * The person who is not an attorney and who gives notice to the donor to apply to register the EPA
     *
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\PersonNotifyDonor")
     * @ORM\JoinTable(name="pa_person_notify_donor",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="person_notify_donor_id", referencedColumnName="id")}
     * )
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $personNotifyDonor;

    /**
     * @ORM\Column(type = "boolean",options={"default"=0})
     * @var bool
     */
    protected $hasRelativeToNotice;

    /**
     * @ORM\Column(type = "boolean",options={"default"=0})
     * @var bool
     */
    protected $areAllAttorneysApplyingToRegister;

    /**
     * It must have at least 3 relatives to be notified to create an EPA.
     *
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\NotifiedRelative")
     * @ORM\JoinTable(name="pa_notified_relatives",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_relative_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id"="ASC"})
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $notifiedRelatives;

    /**
     * The attorneys who are not applying to register the EPA. They need to be notified by the attorneys who are
     * applying to register the EPA.
     *
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\NotifiedAttorney")
     * @ORM\JoinTable(name="pa_notified_attorneys",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_attorney_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id"="ASC"})
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $notifiedAttorneys;

    /**
     * When donor signed this EPA.
     *
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="epaDonorSignatureDate")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $epaDonorSignatureDate;

    /**
     * When donor was notified for applying to register this EPA.
     *
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="epaDonorNoticeGivenDate")
     * @Type("string")
     * @Groups("api-task-list")
     *
     */
    protected $epaDonorNoticeGivenDate;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var bool
     * @Groups("api-task-list")
     */
    protected $donorHasOtherEpas = false;

    /**
     * @ORM\Column(type = "text")
     * @var string
     * @Groups("api-task-list")
     */
    protected $otherEpaInfo;

    public function __construct()
    {
        parent::__construct();
        $this->notifiedRelatives = new ArrayCollection();
        $this->notifiedAttorneys = new ArrayCollection();
    }

    /**
     * @param \DateTime $signatureDate
     *
     * @return Epa
     */
    public function setEpaDonorSignatureDate(\DateTime $signatureDate = null)
    {
        if (is_null($signatureDate)) {
            $signatureDate = new \DateTime();
        }
        $this->epaDonorSignatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getEpaDonorSignatureDate()
    {
        return $this->epaDonorSignatureDate;
    }

    /**
     * @param \DateTime $noticeGivenDate
     *
     * @return Epa
     */
    public function setEpaDonorNoticeGivenDate(\DateTime $noticeGivenDate = null)
    {
        if (is_null($noticeGivenDate)) {
            $noticeGivenDate = new \DateTime();
        }
        $this->epaDonorNoticeGivenDate = $noticeGivenDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getEpaDonorNoticeGivenDate()
    {
        return $this->epaDonorNoticeGivenDate;
    }

    /**
     * @param   bool $hasOtherEpas
     *
     * @return  Epa
     */
    public function setDonorHasOtherEpas($hasOtherEpas)
    {
        $this->donorHasOtherEpas = (bool)$hasOtherEpas;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDonorHasOtherEpas()
    {
        return $this->donorHasOtherEpas;
    }

    /**
     * Alias for Epa::getDonorHasOtherEpas
     * @return bool
     */
    public function hasOtherEpas()
    {
        return $this->getDonorHasOtherEpas();
    }

    /**
     * @param   string $epaInfo
     *
     * @return  Epa
     */
    public function setOtherEpaInfo($epaInfo)
    {
        $this->otherEpaInfo = $epaInfo;

        return $this;
    }

    /**
     * @return string
     */
    public function getOtherEpaInfo()
    {
        return $this->otherEpaInfo;
    }

    /**
     * @param Person $person
     *
     * @return CaseItem
     * @throws \LogicException
     */
    public function addPerson(Person $person)
    {
        if ($person instanceof NotifiedAttorney) {
            $this->addNotifiedAttorney($person);
        } elseif ($person instanceof AttorneyAbstract) {
            $this->addAttorney($person);
        } elseif ($person instanceof NotifiedRelative) {
            $this->addNotifiedRelative($person);
        } elseif ($person instanceof PersonNotifyDonor) {
            $this->addPersonNotifyDonor($person);
        } elseif ($person instanceof Correspondent) {
            $this->setCorrespondent($person);
        } elseif ($person instanceof Donor) {
            $this->setDonor($person);
        } else {
            throw new \LogicException(__CLASS__ . ' does not support a person of type ' . get_class($person));
        }

        return $this;
    }

    /**
     * @param PersonNotifyDonor $personNotifyDonor
     *
     * @return EPA
     */
    public function addPersonNotifyDonor(PersonNotifyDonor $personNotifyDonor)
    {
        $this->personNotifyDonor = $personNotifyDonor;

        return $this;
    }

    /**
     * @return ArrayCollection $personNotifyDonor
     */
    public function getPersonNotifyDonor()
    {
        return $this->personNotifyDonor;
    }

    /**
     * @param ArrayCollection $personNotifyDonor
     *
     * @return EPA
     */
    public function setPersonNotifyDonor(PersonNotifyDonor $personNotifyDonor)
    {
        $this->personNotifyDonor = $personNotifyDonor;

        return $this;
    }

    /**
     * @param NotifiedRelative $notifiedRelative
     *
     * @return EPA
     */
    public function addNotifiedRelative(NotifiedRelative $notifiedRelative)
    {
        if (is_null($this->notifiedRelatives)) {
            $this->notifiedRelatives = new ArrayCollection();
        }

        if (!$this->notifiedRelatives->contains($notifiedRelative)) {
            $this->notifiedRelatives->add($notifiedRelative);
        }

        return $this;
    }

    /**
     * @return ArrayCollection $notifiedRelatives
     */
    public function getNotifiedRelatives()
    {
        if (null === $this->notifiedRelatives) {
            $this->notifiedRelatives = new ArrayCollection();
        }

        return $this->notifiedRelatives;
    }

    /**
     * @param ArrayCollection $notifiedRelatives
     *
     * @return EPA
     */
    public function setNotifiedRelatives(ArrayCollection $notifiedRelatives)
    {
        foreach ($notifiedRelatives as $notifiedRelative) {
            $this->addNotifiedRelative($notifiedRelative);
        }

        return $this;
    }


    /**
     * @param NotifiedAttorney $attorney
     *
     * @return EPA
     */
    public function addNotifiedAttorney(NotifiedAttorney $attorney)
    {
        if (is_null($this->notifiedAttorneys)) {
            $this->notifiedAttorneys = new ArrayCollection();
        }

        if (!$this->notifiedAttorneys->contains($attorney)) {
            $this->notifiedAttorneys->add($attorney);
        }

        return $this;
    }

    /**
     * @return ArrayCollection $attorneys
     */
    public function getNotifiedAttorneys()
    {
        if (null === $this->notifiedAttorneys) {
            $this->notifiedAttorneys = new ArrayCollection();
        }

        return $this->notifiedAttorneys;
    }

    /**
     * @param ArrayCollection $attorneys
     *
     * @return EPA
     */
    public function setNotifiedAttorneys(ArrayCollection $attorneys)
    {
        foreach ($attorneys as $attorney) {
            $this->addNotifiedAttorney($attorney);
        }

        return $this;
    }

    /**
     * @param   bool $hasRelativeToNotice
     *
     * @return  Epa
     */
    public function setHasRelativeToNotice($hasRelativeToNotice)
    {
        $this->hasRelativeToNotice = (bool)$hasRelativeToNotice;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasRelativeToNotice()
    {
        return $this->hasRelativeToNotice;
    }

    /**
     * @param   bool $allAttorneyApplyingToRegister
     *
     * @return  Epa
     */
    public function setAreAllAttorneysApplyingToRegister($allAttorneyApplyingToRegister)
    {
        $this->areAllAttorneysApplyingToRegister = (bool)$allAttorneyApplyingToRegister;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAreAllAttorneysApplyingToRegister()
    {
        return $this->areAllAttorneysApplyingToRegister;
    }
}
