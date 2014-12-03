<?php

namespace Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use Opg\Core\Model\Entity\CaseActor\Deputy;

/**
 * Class HasDeputies
 * @package Opg\Core\Model\Entity\CaseItem\Deputyship\Decorator
 */
trait HasDeputies
{
    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\Deputy")
     * @ORM\JoinTable(
     *     joinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="deputy_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id"="ASC"})
     * @ReadOnly
     * @Groups({"api-poa-list","api-task-list","api-person-get"})
     * @var ArrayCollection
     */
    protected $deputies;

    protected function initDeputies()
    {
        if (null === $this->deputies) {
            $this->deputies = new ArrayCollection();
        }
    }

    /**
     * @param Deputy $deputy
     * @return HasDeputiesInterface
     */
    public function addDeputy(Deputy $deputy)
    {
        $this->initDeputies();

        $this->deputies->add($deputy);

        return $this;
    }

    /**
     * @param ArrayCollection $deputies
     * @return HasDeputiesInterface
     */
    public function setDeputies(ArrayCollection $deputies)
    {
        $this->deputies = new ArrayCollection();

        foreach ($deputies as $deputy) {
            $this->addDeputy($deputy);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeputies()
    {
        $this->initDeputies();

        return $this->deputies;
    }

    /**
     * @param Deputy $deputy
     * @return boolean
     */
    public function hasDeputy(Deputy $deputy)
    {
        $this->initDeputies();

        return $this->deputies->contains($deputy);
    }

    /**
     * @param Deputy $deputy
     * @return HasDeputiesInterface
     */
    public function removeDeputy(Deputy $deputy)
    {
        if (true === $this->hasDeputy($deputy)) {
            $this->deputies->removeElement($deputy);
        }

        return $this;
    }
}
