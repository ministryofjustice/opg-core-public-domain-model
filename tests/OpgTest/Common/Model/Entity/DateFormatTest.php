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
        $expected = 'd/m/Y H:i:s';

        $this->assertEquals($expected, OPGDateFormat::getDateTimeFormat());
    }

    public function testCreateDateTimeFail()
    {
        $data = 'This is not a valid date';

        $this->assertFalse(OPGDateFormat::createDateTime($data));
    }

    public function testCreateDateOnly()
    {
        $expected = '01/05/1978';

        $this->assertTrue(OPGDateFormat::createDateTime($expected) instanceof \DateTime);
    }

    public function testCreateDateTime()
    {
        $expected = '01/05/1978 00:00:00';

        $this->assertTrue(OPGDateFormat::createDateTime($expected) instanceof \DateTime);
        $this->assertEquals(
            $expected,
            OPGDateFormat::createDateTime($expected)->format(OPGDateFormat::getDateTimeFormat())
        );
    }
}
