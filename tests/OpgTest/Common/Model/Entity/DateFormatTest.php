<?php

namespace OpgTest\Common\Model\Entity;

use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

class DateFormatTest extends \PHPUnit_Framework_TestCase
{
    public function testDateFormat()
    {
        $expected = 'd/m/Y';

        $this->assertEquals($expected, OPGDateFormat::getDateFormat());
    }

    public function testDateTimeFormat()
    {
        $expected = 'd/m/Y h:i:s';

        $this->assertEquals($expected, OPGDateFormat::getDateTimeFormat());
    }
}
