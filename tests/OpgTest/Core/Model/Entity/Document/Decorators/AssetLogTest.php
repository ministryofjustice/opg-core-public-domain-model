<?php

namespace OpgTest\Core\Model\Entity\Document\Decorators;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Asset\Asset;
use Opg\Core\Model\Entity\Document\Decorators\AssetLog;
use Opg\Core\Model\Entity\Document\Decorators\HasAssetLog;

class AssetLogStub implements HasAssetLog
{
    use AssetLog;

    public function __unset($value) {
        if (property_exists(get_class($this), $value)) {
            $this->{$value} = null;
        }
    }
}
class AssetLogTest extends \PHPUnit_Framework_TestCase
{
    /** @var  AssetLogStub */
    protected $assetLog;

    public function setUp()
    {
        $this->assetLog = new AssetLogStub();
    }

    public function testSetUp()
    {
        unset($this->{'assets'});
        $this->assertTrue($this->assetLog instanceof HasAssetLog);
        $this->assertEmpty($this->assetLog->getAssets()->toArray());
    }

    public function testAssetCollection()
    {
        $collection = new ArrayCollection();
        $collection->add((new Asset())->setId(1));
        $collection->add((new Asset())->setId(2));
        $collection->add((new Asset())->setId(3));

        $this->assertTrue($this->assetLog->setAssets($collection) instanceof HasAssetLog);

        $this->assertTrue($this->assetLog->assetExists($collection->first()));

        $this->assertTrue($this->assetLog->removeAsset($collection->first()) instanceof HasAssetLog);

        $this->assertFalse($this->assetLog->assetExists($collection->first()));

    }
}
