<?php

namespace Opg\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\HasIdInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;

/**
 * Class HasId
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasId
{
    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true})
     * @ORM\GeneratedValue(strategy = "SEQUENCE")
     * @ORM\Id
     * @Groups({"api-case-list","api-task-list","api-person-get","api-warning-list"})
     * @Accessor(getter="getId", setter="setId")
     * @Type("integer")
     * @var int $id
     */
    protected $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return HasIdInterface
     */
    public function setId( $id )
    {
        $this->id = (int) $id;

        return $this;
    }
}
