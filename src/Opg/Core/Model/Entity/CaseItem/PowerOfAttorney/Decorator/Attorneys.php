<?php

namespace Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Decorator;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Interfaces\HasAttorneys;
use Opg\Core\Model\Entity\CaseActor\AttorneyAbstract;

/**
 * Class Attorneys
 * @package Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Decorator#
 */
trait Attorneys
{
    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\Person")
     * @ORM\OrderBy({"id"="ASC"})
     * @ReadOnly
     * @Groups({"api-person-get"})
     * @var ArrayCollection
     */
    protected $attorneys;

    protected function initAttorneys()
    {
        if (null === $this->attorneys) {
            $this->attorneys = new ArrayCollection();
        }
    }

    /**
     * @return ArrayCollection $attorneys
     */
    public function getAttorneys()
    {
        $this->initAttorneys();

        return $this->attorneys;
    }

    /**
     * @param ArrayCollection $attorneys
     * @return HasAttorneys
     */
    public function setAttorneys(ArrayCollection $attorneys)
    {
        foreach ($attorneys as $attorney) {
            $this->addAttorney($attorney);
        }

        return $this;
    }

    /**
     * @param AttorneyAbstract $attorney
     * @return HasAttorneys
     */
    public function addAttorney(AttorneyAbstract $attorney)
    {
        $this->initAttorneys();

        if (!$this->attorneyExists($attorney)) {
            $this->attorneys->add($attorney);
        }

        return $this;
    }

    /**
     * @param AttorneyAbstract $attorney
     * @return bool
     */
    public function attorneyExists(AttorneyAbstract $attorney)
    {
        $this->initAttorneys();

        return $this->attorneys->contains($attorney);
    }

    /**
     * @param AttorneyAbstract $attorney
     * @return HasAttorneys
     */
    public function removeAttorney(AttorneyAbstract $attorney)
    {
        $this->initAttorneys();

        if ($this->attorneyExists($attorney)) {
            $this->attorneys->removeElement($attorney);
        }

        return $this;
    }

    /**
     * @param AttorneyAbstract $attorney
     * @return ArrayCollection
     */
    public function findAttorney(AttorneyAbstract $attorney)
    {
        $this->initAttorneys();

        return $this->attorneys->filter(
            function($item) use ($attorney){
                if ('' !== $attorney->getDobString()) {
                    return (
                        $item->getTitle() === $attorney->getTitle() &&
                        $item->getFirstname() === $attorney->getFirstname() &&
                        $item->getMiddleName() === $attorney->getMiddlename() &&
                        $item->getSurname() === $attorney->getSurname() &&
                        $item->getDob() === $attorney->getDob()
                    );
                } else {
                    return (
                        $item->getTitle() === $attorney->getTitle() &&
                        $item->getFirstname() === $attorney->getFirstname() &&
                        $item->getMiddleName() === $attorney->getMiddlename() &&
                        $item->getSurname() === $attorney->getSurname()
                    );
                }
            }
        );
    }
}
