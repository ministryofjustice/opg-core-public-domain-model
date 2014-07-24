<?php


namespace Opg\Core\Model\Entity\Assignable;


use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 *
 * Class NullEntity
 * @package Opg\Core\Model\Entity\Assignable
 */
class NullEntity extends AssignableComposite implements EntityInterface, IsAssignee
{

    const NULL_USER_ID = null;

    const NULL_USER_NAME = 'Unassigned';

    public function __construct()
    {
        $this->name = self::NULL_USER_NAME;
        $this->id = self::NULL_USER_ID;
    }
    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return self::NULL_USER_ID;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return self::NULL_USER_NAME;
    }


    /**
     * @param bool $exposeClassname
     * @return array
     */
    public function toArray($exposeClassname = false)
    {
        return array();
    }

    /**
     * @param InputFilterInterface $inputFilter
     * @return void|InputFilterAwareInterface
     * @throws \LogicException
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \LogicException('Not implemented');
    }

    /**
     * @return void|InputFilterInterface
     * @throws \LogicException
     */
    public function getInputFilter()
    {
        throw new \LogicException('Not implemented');
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return self::NULL_USER_NAME;
    }
}
