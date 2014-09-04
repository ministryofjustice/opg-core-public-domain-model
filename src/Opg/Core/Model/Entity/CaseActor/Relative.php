<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\HasRelationshipToDonor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Relative extends NonCaseContact implements HasRelationshipToDonor
{
    use RelationshipToDonor;
}
