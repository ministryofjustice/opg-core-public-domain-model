<?php

namespace Opg\Core\Model\Entity\Asset;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;

/**
 * Class AssetLog
 * @package Opg\Core\Model\Entity\Document\Asset
 *
 * @ORM\Entity
 */
class Asset implements HasIdInterface
{
    use HasId;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $assetName;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @var float
     */
    protected $assetValue;

    /**
     * @param string $assetName
     * @return Asset
     */
    public function setAssetName($assetName)
    {
        $this->assetName = $assetName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAssetName()
    {
        return $this->assetName;
    }

    /**
     * @param float $assetValue
     * @return Asset
     */
    public function setAssetValue($assetValue)
    {
        $this->assetValue = (float)$assetValue;

        return $this;
    }

    /**
     * @return float
     */
    public function getAssetValue()
    {
        return $this->assetValue;
    }


}
