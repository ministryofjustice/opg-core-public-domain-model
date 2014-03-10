<?php
namespace Opg\Core\Model\Entity\CaseItem\LayDeputy;

use Opg\Core\Model\Entity\Deputyship\Deputyship;
use Opg\Core\Model\Entity\Person\Person;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class LayDeputy extends Deputyship
{

    /**
     * @throws \LogicException
     */
    public function getInputFilter()
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * @param InputFilterInterface $filter
     *
     * @throws \LogicException
     */
    public function setInputFilter(InputFilterInterface $filter)
    {
        throw new \LogicException('Not implemented.');
    }

    /**
     * @param Person $person
     * @return \Opg\Core\Model\Entity\CaseItem\CaseItem|void
     * @throws \LogicException
     */
    public function addPerson(Person $person)
    {
        throw new \LogicException('Not implemented.');
    }
}
