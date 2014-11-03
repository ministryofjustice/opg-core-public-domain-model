<?php


namespace Opg\Core\Model\Entity\PowerOfAttorney\Decorator;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;

trait DonorCannotSignForm
{
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Groups({"api-person-get"})
     * @Accessor(getter="getSigningOnBehalfDateString",setter="setSigningOnBehalfDateString")
     */
    protected $signingOnBehalfDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $signingOnBehalfFullName;

    /**
     * @param \DateTime $signingOnBehalfDate
     * @return $this
     */
    public function setSigningOnBehalfDate(\DateTime $signingOnBehalfDate = null)
    {
        $this->signingOnBehalfDate = $signingOnBehalfDate;

        return $this;
    }

    /**
     * @param string $signingOnBehalfDate
     * @return $this
     */
    public function setSigningOnBehalfDateString($signingOnBehalfDate = '')
    {
        if (!empty($signingOnBehalfDate)) {
            $this->setSigningOnBehalfDate(OPGDateFormat::createDateTime($signingOnBehalfDate));
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getSigningOnBehalfDate()
    {
        return $this->signingOnBehalfDate;
    }

    /**
     * @return string
     */
    public function getSigningOnBehalfDateString()
    {
        if (null !== $this->getSigningOnBehalfDate()) {
            return $this->getSigningOnBehalfDate()->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param string $signingOnBehalfFullName
     * @return $this
     */
    public function setSigningOnBehalfFullName($signingOnBehalfFullName = "")
    {
        $this->signingOnBehalfFullName = $signingOnBehalfFullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getSigningOnBehalfFullName()
    {
        return $this->signingOnBehalfFullName;
    }


}
