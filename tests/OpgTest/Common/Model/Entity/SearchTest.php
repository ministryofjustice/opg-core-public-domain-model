<?php
namespace OpgTest\Common\Model\Entity;

use Opg\Common\Model\Entity\Search;

/**
 * Search test case.
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Search
     */
    private $search;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->search = new Search();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->search = null;

        parent::tearDown();
    }

    public function testGetSetQuery()
    {
        $query = 'SearchQuery';

        $this->search->setQuery($query);

        $this->assertEquals(
            $query,
            $this->search->getQuery()
        );
    }

    public function testExchangeArray()
    {
        $data = array(
            'query' => 'SearchQuery'
        );

        $this->search->exchangeArray($data);

        $this->assertEquals(
            $data['query'],
            $this->search->getQuery()
        );
    }

    public function testNoErrorMessages()
    {
        $this->assertEquals(
            array('errors'=>array()),
            $this->search->getErrorMessages()
        );
    }

    public function testQueryValidationSuccess()
    {
        $data = array(
            'query' => 'SearchQuery'
        );

        $this->search->exchangeArray($data);

        $this->assertTrue(
            $this->search->isValid()
        );

        $this->assertEquals(
            array('errors' => array()),
            $this->search->getErrorMessages()
        );
    }

    public function testQueryValidationRequiredFailureWithMessages()
    {
        $data = array(
            'query' => ''
        );

        $this->search->exchangeArray($data);

        $this->assertFalse(
            $this->search->isValid()
        );

        $validationMessage = array(
            'errors' => array(
                'query' => array(
                    'isEmpty' => 'Value is required and can\'t be empty'
                )
            )
        );

        $this->assertEquals(
            $validationMessage,
            $this->search->getErrorMessages()
        );
    }

    public function testQueryMinimumValidationFailureWithMessage()
    {
        $data = array(
            'query' => 't'
        );

        $this->search->exchangeArray($data);

        $this->assertFalse(
            $this->search->isValid()
        );

        $validationMessage = array(
            'errors' => array(
                'query' => array(
                    'stringLengthTooShort' => "The input is less than 2 characters long"
                )
            )
        );

        $this->assertEquals(
            $validationMessage,
            $this->search->getErrorMessages()
        );
    }

    public function testQueryMaximumValidationFailureWithMessage()
    {
        $data = array(
            'query' => str_pad('xyz', 129, 'abc')
        );

        $this->assertEquals(129, strlen($data['query']));

        $this->search->exchangeArray($data);

        $this->assertFalse(
            $this->search->isValid()
        );

        $validationMessage = array(
            'errors' => array(
                'query' => array(
                    'stringLengthTooLong' => "The input is more than 128 characters long"
                )
            )
        );

        $this->assertEquals(
            $validationMessage,
            $this->search->getErrorMessages()
        );
    }
}
