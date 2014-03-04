<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Traits\Party;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Person;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 *
 * @package Opg Domain Model
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class Correspondent implements PartyInterface
{
    use Party;
    use Person;
    use Company;
    use ToArray;
}
