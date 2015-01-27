<?php

namespace Opg\Core\Model\Entity\LineItem;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;

/**
 * Class LineItem
 * @package Opg\Core\Model\Entity\LineItem
 *
 * @ORM\Entity
 */
class LineItem implements HasIdInterface
{
    use HasId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $itemName;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    protected $itemValue;

    /**
     * @param string $itemName
     * @return LineItem
     */
    public function setName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->itemName;
    }

    /**
     * @param float $itemValue
     * @return LineItem
     */
    public function setValue($itemValue)
    {
        $this->itemValue = (float)$itemValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->itemValue;
    }


}
