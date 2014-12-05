<?php

namespace OpgTest\Core\Model\Entity\Asset;


use Opg\Core\Model\Entity\Asset\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Asset */
    protected $asset;

    public function setUp()
    {
        $this->asset = new Asset();
    }

    public function testGetSetId()
    {
        $expected = 1;
        $this->assertEmpty($this->asset->getId());
        $this->assertTrue($this->asset->setId($expected) instanceof Asset);
        $this->assertEquals($expected, $this->asset->getId());
    }

    public function testGetSetAssetName()
    {
        $expected = 'asset name';
        $this->assertEmpty($this->asset->getAssetName());
        $this->assertTrue($this->asset->setAssetName($expected) instanceof Asset);
        $this->assertEquals($expected, $this->asset->getAssetName());
    }

    public function testGetSetAssetValue()
    {
        $expected = 2500.34;
        $this->assertEmpty($this->asset->getAssetValue());
        $this->assertTrue($this->asset->setAssetValue($expected) instanceof Asset);
        $this->assertEquals($expected, $this->asset->getAssetValue());
    }
}
