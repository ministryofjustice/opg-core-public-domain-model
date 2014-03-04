<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\Traits\IteratorAggregate as IteratorAggregateTrait;
use Opg\Common\Model\Entity\Traits\ToArray as ToArrayTrait;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;

/**
 * InputFilter test case.
 */
class InputFilterTest extends \PHPUnit_Framework_TestCase implements \IteratorAggregate
{

    use ToArrayTrait;
    use IteratorAggregateTrait;
    use InputFilterTrait;

    protected $username;

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'query',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 2,
                                    'max'      => 4,
                                ),
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'username',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 2,
                                    'max'      => 4,
                                ),
                            )
                        )
                    )
                )
            );
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
    
    public function testThrowsExceptionOnUnusedSetInputFilterMethod()
    {
        $inputFilterMock = \Mockery::mock('Zend\InputFilter\InputFilterInterface');
        $this->setExpectedException('Opg\Common\Exception\UnusedException');
        $this->setInputFilter($inputFilterMock);
    }

    public function testValidationFails()
    {
        $this->assertFalse(
            $this->isValid()
        );

        $this->username = 'a';

        $this->assertFalse(
            $this->isValid()
        );

        $this->username = 'a';
        $this->query    = 'a';

        $this->assertFalse(
            $this->isValid()
        );

        $this->username = 'abcdef';
        $this->query    = 'abcdef';

        $this->assertFalse(
            $this->isValid()
        );
    }

    public function testValidationSuccessful()
    {
        $this->username = 'abc';
        $this->query    = 'abc';

        $this->assertTrue(
            $this->isValid()
        );
    }

    public function testPartialValidationSuccessful()
    {
        $this->username = 'abc';

        $this->assertTrue(
            $this->isValid(array('username'))
        );
    }

    public function testPartialValidationFails()
    {
        $this->username = 'abc';

        $this->assertFalse(
            $this->isValid(array('query'))
        );
    }

    public function testGetMessagesEmpty()
    {
        $this->assertEquals(
            ['errors' => array()],
            $this->getErrorMessages()
        );
    }

    public function testAddExternalError() {
        $this->assertEquals(
            ['errors' => array()],
            $this->getErrorMessages()
        );

        $this->addExternalError('username', 'BlankName', 'This name is blank');

        $expected = ['errors' => ['username' => ['BlankName' => 'This name is blank']]];

        $this->assertEquals(
            $expected,
            $this->getErrorMessages()
        );
    }

    public function testAddExternalErrorThrowsException() {
        $this->assertEquals(
            ['errors' => array()],
            $this->getErrorMessages()
        );

        try {
            $this->addExternalError('not present', 'BlankName', 'This name is blank');
        }
        catch(\InvalidArgumentException $e) {
            return;
        }

        $this->fail('This test should have thrown an \InvalidArgumentException');
    }
}
