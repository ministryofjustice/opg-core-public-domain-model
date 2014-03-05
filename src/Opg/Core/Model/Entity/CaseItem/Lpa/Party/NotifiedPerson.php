<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class NotifiedPerson extends BasePerson implements PartyInterface, EntityInterface
{
    use ToArray {
        toArray as toTraitArray;
    }
    use ExchangeArray;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $notifiedDate;

    /**
     * @return string $notifiedDate
     */
    public function getNotifiedDate()
    {
        return $this->notifiedDate;
    }

    /**
     * @param string $notifiedDate
     * @return NotifiedPerson
     */
    public function setNotifiedDate($notifiedDate)
    {
        $this->notifiedDate = $notifiedDate;
        return $this;
    }

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
