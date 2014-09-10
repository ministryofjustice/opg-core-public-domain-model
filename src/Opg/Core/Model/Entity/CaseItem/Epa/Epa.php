<?php
namespace Opg\Core\Model\Entity\CaseItem\Epa;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseActor\NotifiedRelative;
use Opg\Core\Model\Entity\CaseActor\NotifiedAttorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\CaseType as CaseTypeValidator;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Zend\Filter\FilterChain;
use Zend\Validator\ValidatorChain;

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
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\NotifiedRelative")
     * @ORM\JoinTable(name="pa_notified_relatives",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_relative_id", referencedColumnName="id")}
     * )
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $notifiedRelatives;
    
    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\NotifiedAttorney")
     * @ORM\JoinTable(name="pa_notified_attorneys",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_attorney_id", referencedColumnName="id")}
     * )
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $notifiedAttorneys;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getEpaDonorSignatureDateString",setter="setEpaDonorSignatureDateString")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $epaDonorSignatureDate;

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
        $this->notifiedRelatives = new ArrayCollection();
        $this->notifiedAttorneys = new ArrayCollection();
    }

    /**
     * @param \DateTime $signatureDate
     *
     * @return $this
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
     * @param string $signatureDate
     *
     * @return Epa
     */
    public function setEpaDonorSignatureDateString($signatureDate)
    {
        if (!empty($signatureDate)) {
            $signatureDate = OPGDateFormat::createDateTime($signatureDate);
            $this->setEpaDonorSignatureDate($signatureDate);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEpaDonorSignatureDate()
    {
        return $this->epaDonorSignatureDate;
    }

    /**
     * @return string
     */
    public function getEpaDonorSignatureDateString()
    {
        if (!empty($this->epaDonorSignatureDate)) {
            return $this->epaDonorSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
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
            $this->addRelative($notifiedRelative);
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
}
