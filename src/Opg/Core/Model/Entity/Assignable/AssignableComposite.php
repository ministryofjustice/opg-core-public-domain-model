<?php

namespace Opg\Core\Model\Entity\Assignable;

use Opg\Common\Model\Entity\HasCasesInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\HasTasksInterface;
use Opg\Common\Model\Entity\Traits\HasCases;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\HasTasks;
use Opg\Common\Model\Entity\Traits\ToArray;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 * @ORM\Table(name = "assignees")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "assignee_user" = "Opg\Core\Model\Entity\Assignable\User",
 *     "assignee_team" = "Opg\Core\Model\Entity\Assignable\Team",
 *     "assignee_null" = "Opg\Core\Model\Entity\Assignable\NullEntity"
 * })
 *
 * Class Composite
 * @package Opg\Core\Model\Entity\Composite
 */
abstract class AssignableComposite implements IsAssignee, \IteratorAggregate, HasTasksInterface, HasIdInterface, HasCasesInterface
{
    use ToArray;
    use HasTasks;
    use HasId;
    use HasCases;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     * @Accessor(getter="getName", setter="setName")
     */
    protected $name;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Assignable\Team", mappedBy="members")
     * @var ArrayCollection
     * @Type("ArrayCollection")
     * @Groups({"api-poa-list","api-task-list"})
     * @MaxDepth(3)
     */
    protected $teams;

    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getDisplayName")
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     * @ReadOnly
     */
    protected $displayName;

    public function __construct()
    {
        $this->cases            = new ArrayCollection();
        $this->tasks            = new ArrayCollection();
        $this->teams            = new ArrayCollection();
    }

    /**
     * @param string $name
     *
     * @return AssignableComposite
     */
    public function setName( $name )
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \RecursiveArrayIterator
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator( $this->toArray() );
    }

    /**
     * @return string
     */
    abstract public function getDisplayName();

    /**
     * @param Team $team
     * @return $this
     */
    public function addTeam(Team $team)
    {
        if (null === $this->teams) {
            $this->teams = new ArrayCollection();
        }

        if (false === $this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $teams
     * @return $this
     */
    public function setTeams(ArrayCollection $teams)
    {
        $this->teams = $teams;

        return $this;
    }

    /**
     * @param ArrayCollection $teams
     * @return $this
     */
    public function addTeams(ArrayCollection $teams)
    {
        foreach ($teams->toArray() as $team) {
            if ($team instanceof Team) {
                $this->addTeam($team);
            }
        }

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getTeams()
    {
        if (null === $this->teams) {
            $this->teams = new ArrayCollection();
        }

        return $this->teams;
    }

    /**
     * @param Team $team
     * @return $this
     */
    public function removeTeam(Team $team)
    {
        if (null == $this->teams) {
            $this->teams = new ArrayCollection();
        }

        $this->teams->removeElement($team);

        return $this;
    }
}
