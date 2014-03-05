<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class Correspondent extends BasePerson implements PartyInterface, EntityInterface
{
    use Company;
    use ToArray {
        toArray as toTraitArray;
    }
    use ExchangeArray;

    /**
     * @return void|InputFilterInterface
     * @throws \Opg\Common\Exception\UnusedException
     */
    public function getInputFilter()
    {
        throw new UnusedException();
    }

    /**
     * @param InputFilterInterface $inputFilter
     *
     * @return void|\Zend\InputFilter\InputFilterAwareInterface
     * @throws \Opg\Common\Exception\UnusedException
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new UnusedException();
    }

    /**
     * @param bool $exposeClassName
     *
     * @return array
     */
    public function toArray($exposeClassName = TRUE)
    {
        return $this->toTraitArray($exposeClassName);
    }
}
