<?php
namespace Opg\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\LineItem\LineItem;

interface HasAssetLog
{
    /**
     * @return ArrayCollection
     */
    public function getAssets();

    /**
     * @param LineItem $lineItem
     * @return HasAssetLog
     */
    public function addAsset(LineItem $lineItem);

    /**
     * @param ArrayCollection $assets
     * @return HasAssetLog
     */
    public function setAssets(ArrayCollection $assets);

    /**
     * @param LineItem $lineItem
     * @return boolean
     */
    public function assetExists(LineItem $lineItem);

    /**
     * @param LineItem $lineItem
     * @return HasAssetLog
     */
    public function removeAsset(LineItem $lineItem);
}
