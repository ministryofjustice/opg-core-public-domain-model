<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\HasWarningsInterface;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\Warning\Warning;

/**
 * Class HasWarnings
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasWarnings
{
    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\Warning\Warning", mappedBy="person", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @Accessor(getter="getActiveWarnings")
     * @Groups({"api-person-get","api-warning-list"})
     */
    protected $warnings;

    /**
     * @return ArrayCollection
     */
    public function getWarnings()
    {
        $this->initWarnings();

        return $this->warnings;
    }

    /**
     * @param ArrayCollection $warnings
     * @return HasWarningsInterface
     */
    public function setWarnings(ArrayCollection $warnings)
    {
        $this->warnings = $warnings;

        return $this;
    }

    /**
     * @param Warning $warning
     * @return $this
     */
    public function addWarning(Warning $warning)
    {
        $this->initWarnings();

        $this->warnings->add($warning);

        if ($this instanceof Person) {
            $warning->setPerson($this);
        }

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getActiveWarnings()
    {
        $this->initWarnings();

        return
            $this->warnings->filter(
                function ($item) {
                    return $item->isActive();
                }
            );
    }

    /**
     * @internals
     */
    protected function initWarnings()
    {
        if (null === $this->warnings) {
            $this->warnings = new ArrayCollection();
        }
    }
}
