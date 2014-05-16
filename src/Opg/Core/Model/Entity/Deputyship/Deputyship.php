<?php
namespace Opg\Core\Model\Entity\Deputyship;

use Opg\Common\Model\Entity\Traits\ToArray;

use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name = "case_deputyships")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "lay" = "Opg\Core\Model\Entity\CaseItem\LayDeputy\LayDeputy",
 * })
 */
abstract class Deputyship extends CaseItem
{
    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note", cascade={"persist"})
     * @ORM\JoinTable(name="deputyship_notes",
     *     joinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="note_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection
     */
    protected $notes;
}
