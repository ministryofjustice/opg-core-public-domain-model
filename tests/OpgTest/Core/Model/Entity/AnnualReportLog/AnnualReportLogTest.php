<?php
namespace OpgTest\Core\Model\AnnualReportLog;

use Opg\Core\Model\Entity\AnnualReportLog\AnnualReportLog;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Order;


class AnnualReportLogTest extends \PHPUnit_Framework_TestCase
{
    protected $deputyshipOrder;

    public function setUp()
    {
        parent::setUp();

        $this->deputyshipOrder = new Order();
    }


    public function testSetDeputyshipOrder()
    {
        $annualReportLog = new AnnualReportLog();

        $annualReportLog->setDeputyshipOrder($this->deputyshipOrder);

        $this->assertEquals(
            $this->deputyshipOrder,
            $annualReportLog->getDeputyshipOrder()
        );
    }

    public function testSetDueDate()
    {
        $annualReportLog = new AnnualReportLog();

        $annualReportLog->setDueDate(new \DateTime('2015-05-05'));

        $this->assertEquals(
            new \DateTime('2015-05-05'),
            $annualReportLog->getDueDate()
        );
    }

    public function testSetReportingPeriodEndDate()
    {
        $annualReportLog = new AnnualReportLog();

        $annualReportLog->setReportingPeriodEndDate(new \DateTime('2015-05-05'));

        $this->assertEquals(
            new \DateTime('2015-05-05'),
            $annualReportLog->getReportingPeriodEndDate()
        );
    }

    public function testSetRevisedDueDate()
    {
        $annualReportLog = new AnnualReportLog();

        $annualReportLog->setRevisedDueDate(new \DateTime('2015-05-05'));

        $this->assertEquals(
            new \DateTime('2015-05-05'),
            $annualReportLog->getRevisedDueDate()
        );
    }

    public function testSetRevisedDueDateEmpty()
    {
        $annualReportLog = new AnnualReportLog();

        $annualReportLog->setRevisedDueDate();

        $this->assertEmpty(
            $annualReportLog->getRevisedDueDate()
        );
    }

    public function testNumberOfChaseLetters()
    {
        $annualReportLog = new AnnualReportLog();

        $annualReportLog->setNumberOfChaseLetters(2);

        $this->assertEquals(
            2,
            $annualReportLog->getNumberOfChaseLetters()
        );
    }

    public function testDeputyshipOrderValidation()
    {
        $annualReportLog = new AnnualReportLog();
        $errorArray = array(
            'errors' => array(
                'deputyshipOrder' => array(
                    'isEmpty' => "Value is required and can't be empty"
                )
            )
        );

        $annualReportLog->setDueDate(new \DateTime('2015-05-05'));
        $annualReportLog->setReportingPeriodEndDate(new \DateTime('2015-05-05'));
        $annualReportLog->setRevisedDueDate(new \DateTime('2015-05-05'));

        $valid = $annualReportLog->isValid();

        $this->assertFalse($valid);
        $this->assertEquals($errorArray, $annualReportLog->getErrorMessages());
    }

    public function testDueDateValidation()
    {
        $annualReportLog = new AnnualReportLog();
        $errorArray = array(
            'errors' => array(
                'dueDate' => array(
                    'isEmpty' => "Value is required and can't be empty"
                )
            )
        );

        $annualReportLog->setDeputyshipOrder($this->deputyshipOrder);
        $annualReportLog->setReportingPeriodEndDate(new \DateTime('2015-05-05'));
        $annualReportLog->setRevisedDueDate(new \DateTime('2015-05-05'));

        $valid = $annualReportLog->isValid();

        $this->assertFalse($valid);
        $this->assertEquals($errorArray, $annualReportLog->getErrorMessages());
    }

    public function testReportingPeriodEndDateValidation()
    {
        $annualReportLog = new AnnualReportLog();
        $errorArray = array(
            'errors' => array(
                'reportingPeriodEndDate' => array(
                    'isEmpty' => "Value is required and can't be empty"
                )
            )
        );

        $annualReportLog->setDeputyshipOrder($this->deputyshipOrder);
        $annualReportLog->setDueDate(new \DateTime('2015-05-05'));
        $annualReportLog->setRevisedDueDate(new \DateTime('2015-05-05'));

        $valid = $annualReportLog->isValid();

        $this->assertFalse($valid);
        $this->assertEquals($errorArray, $annualReportLog->getErrorMessages());
    }

    public function testNumberOfChaseLettersEmptyValidation()
    {
        $annualReportLog = new AnnualReportLog();
        $errorArray = array(
            'errors' => array(
                'numberOfChaseLetters' => array(
                    'isEmpty' => "Value is required and can't be empty"
                )
            )
        );

        $annualReportLog->setDeputyshipOrder($this->deputyshipOrder);
        $annualReportLog->setDueDate(new \DateTime('2015-05-05'));
        $annualReportLog->setReportingPeriodEndDate(new \DateTime('2015-05-05'));
        $annualReportLog->setRevisedDueDate(new \DateTime('2015-05-05'));
        $annualReportLog->setNumberOfChaseLetters('');

        $valid = $annualReportLog->isValid();

        $this->assertFalse($valid);
        $this->assertEquals($errorArray, $annualReportLog->getErrorMessages());
    }

    public function testNumberOfChaseLettersNonIntegerValidation()
    {
        $annualReportLog = new AnnualReportLog();
        $errorArray = array(
            'errors' => array(
                'numberOfChaseLetters' => array(
                    'notInt' => "The input does not appear to be an integer"
                )
            )
        );

        $annualReportLog->setDeputyshipOrder($this->deputyshipOrder);
        $annualReportLog->setDueDate(new \DateTime('2015-05-05'));
        $annualReportLog->setReportingPeriodEndDate(new \DateTime('2015-05-05'));
        $annualReportLog->setRevisedDueDate(new \DateTime('2015-05-05'));
        $annualReportLog->setNumberOfChaseLetters('nonInteger');

        $valid = $annualReportLog->isValid();

        $this->assertFalse($valid);
        $this->assertEquals($errorArray, $annualReportLog->getErrorMessages());
    }



}
