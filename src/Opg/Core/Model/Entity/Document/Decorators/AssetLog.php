<?php

namespace Opg\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\LineItem\LineItem;

/**
 * Class AssetLog
 * @package Opg\Core\Model\Entity\Document\Decorators
 */
trait AssetLog
{

    /**
     * @var ArrayCollection
     */
    protected $assets;

    protected function initAssets()
    {
        if (null === $this->assets) {
            $this->assets = new ArrayCollection();
        }
    }
    /**
     * @return ArrayCollection
     */
    public function getAssets()
    {
       $this->initAssets();

        return $this->assets;
    }

    /**
     * @param LineItem $asset
     * @return HasAssetLog
     */
    public function addAsset(LineItem $asset)
    {
        $this->initAssets();
        $this->assets->add($asset);

        return $this;
    }

    /**
     * @param ArrayCollection $assets
     * @return HasAssetLog
     */
    public function setAssets(ArrayCollection $assets)
    {
        $this->assets = new ArrayCollection();

        foreach ($assets as $asset) {
            $this->addAsset($asset);
        }

        return $this;
    }

    /**
     * @param LineItem $asset
     * @return boolean
     */
    public function assetExists(LineItem $asset)
    {
        $this->initAssets();

        return $this->assets->contains($asset);
    }

    /**
     * @param LineItem $asset
     * @return HasAssetLog
     */
    public function removeAsset(LineItem $asset)
    {
        if ($this->assetExists($asset)) {
            $this->assets->removeElement($asset);
        }

        return $this;
    }
}
