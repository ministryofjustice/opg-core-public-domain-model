<?php
namespace Opg\Core\Model\Entity\CaseItem;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use \Zend\InputFilter\InputFilter;
use \Zend\InputFilter\Factory as InputFactory;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Zend\InputFilter\InputFilterInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name = "business_rules")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\BusinessRuleRepository")
 *
 * @package Opg Core
 */
class BusinessRule implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\Time;
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use \Opg\Common\Model\Entity\Traits\IteratorAggregate;
    use ToArray;
    use ExchangeArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var int $id
     */
    protected $id;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string key
     */
    protected $key;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string value
     */
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney", inversedBy="business_rules")
     * @ORM\JoinColumn(name="case_id", referencedColumnName="id")
     * @var \Opg\Core\Model\Entity\CaseItem\CaseItem
     */
    protected $case;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return BusinessRule
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \Opg\Common\Model\Entity\Traits\InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new InputFilter();
        }

        return $this->inputFilter;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return BusinessRule
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return string
     *
     * @return BusinessRule
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     *
     * @return BusinessRule
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return CaseItem
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @param CaseItem $case
     *
     * @return BusinessRule
     */
    public function setCase(CaseItem $case)
    {
        $this->case = $case;

        return $this;
    }
}
