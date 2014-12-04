<?php


namespace Opg\Core\Model\Entity\Document\Decorators;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Asset\Asset;

interface HasAssetLog
{
    /**
     * @return ArrayCollection
     */
    public function getAssets();

    /**
     * @param Asset $asset
     * @return HasAssetLog
     */
    public function addAsset(Asset $asset);

    /**
     * @param ArrayCollection $assets
     * @return HasAssetLog
     */
    public function setAssets(ArrayCollection $assets);

    /**
     * @param Asset $asset
     * @return boolean
     */
    public function assetExists(Asset $asset);

    /**
     * @param Asset $asset
     * @return HasAssetLog
     */
    public function removeAsset(Asset $asset);
}
