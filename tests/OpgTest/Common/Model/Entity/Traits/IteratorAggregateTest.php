<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * ToArray test case.
 */
class IteratorAggregateTest extends \PHPUnit_Framework_TestCase
{

    use ToArray;
    use IteratorAggregate;

    public function testGetIterator()
    {
        $this->assertInstanceOf(
            'ArrayIterator',
            $this->getIterator()
        );
    }
}
