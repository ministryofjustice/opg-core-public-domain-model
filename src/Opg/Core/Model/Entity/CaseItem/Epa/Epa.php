<?php
namespace Opg\Core\Model\Entity\CaseItem\Epa;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseActor\Relative;
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
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\Relative")
     * @ORM\JoinTable(name="pa_relatives",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="relative_id", referencedColumnName="id")}
     * )
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $relatives;
    

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getEpaDonorSignatureDateString",setter="setEpaDonorSignatureDateString")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $epaDonorSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-task-list")
     */
    protected $epaDonorSignatoryFullName;

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

    /**
     * @ORM\Column(type = "integer",options={"default":1})
     * @var string
     * @Accessor(getter="getTrustCorporationSignedAs",setter="setTrustCorporationSignedAs")
     */
    protected $trustCorporationSignedAs;
    
    public function __construct()
    {
        $this->relatives = new ArrayCollection();
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
     * @param  string $fullName
     *
     * @return Epa
     */
    public function setDonorEpaSignatoryFullName($fullName)
    {
        $this->epaDonorSignatoryFullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDonorEpaSignatoryFullName()
    {
        return $this->epaDonorSignatoryFullName;
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
    public function setOtheEpaInfo($epaInfo)
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
        if ($person instanceof AttorneyAbstract) {
            $this->addAttorney($person);
        } elseif ($person instanceof Relative) {
            $this->addRelative($person);
        } elseif ($person instanceof NotifiedPerson) {
            $this->addNotifiedPerson($person);
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
     * @param string $trustCorporationSignedAs
     * @return Epa
     */
    public function setTrustCorporationSignedAs($trustCorporationSignedAs)
    {
        $this->trustCorporationSignedAs =
            ($trustCorporationSignedAs === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrustCorporationSignedAs()
    {
        return ($this->trustCorporationSignedAs === self::PERMISSION_GIVEN_SINGULAR) ? 'I' : 'We';
    }
    
    /**
     * @param Relative $relative
     *
     * @return EPA
     */
    public function addRelative(Relative $relative)
    {
        if (is_null($this->relatives)) {
            $this->relatives = new ArrayCollection();
        }

        if (!$this->relatives->contains($relative)) {
            $this->relatives->add($relative);
        }

        return $this;
    }
    
    /**
     * @return ArrayCollection $relatives
     */
    public function getRelatives()
    {
        if (null === $this->relatives) {
            $this->relatives = new ArrayCollection();
        }

        return $this->relatives;
    }

    /**
     * @param ArrayCollection $relatives
     *
     * @return EPA
     */
    public function setRelatives(ArrayCollection $relatives)
    {
        foreach ($relatives as $relative) {
            $this->addRelative($relative);
        }

        return $this;
    }

}
