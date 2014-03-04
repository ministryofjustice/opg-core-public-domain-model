<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Traits\Party;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Person;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 *
 * @package Opg Domain Model
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class NotifiedPerson implements PartyInterface
{
    use Party;
    use Person;
    use ToArray;

    /**
     * @var string
     */
    private $notifiedDate;
    
    /**
     * @return string $notifiedDate
     */
    public function getNotifiedDate()
    {
        return $this->notifiedDate;
    }

    /**
     * @param string $notifiedDate
     * return NotifiedPerson
     */
    public function setNotifiedDate($notifiedDate)
    {
        $this->notifiedDate = $notifiedDate;
        return $this;
    }
}
