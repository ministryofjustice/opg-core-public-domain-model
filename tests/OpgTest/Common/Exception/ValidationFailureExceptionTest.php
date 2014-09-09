<?php

namespace OpgTest\Common\Exception;

use Opg\Common\Exception\InvalidParameterValueException;
use Opg\Common\Exception\ValidationFailureException;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Task\Task;

class ValidationFailureExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testException()
    {
        $task = new Task();

        try {
            if (false == $task->isValid()) {
                throw new ValidationFailureException(get_class($task));
            }
        } catch(\Exception $e) {
            $this->assertTrue($e instanceof ValidationFailureException);
            $this->assertEquals($e->getMessage(), 'The class ' . get_class($task).' has invalid data.');
            $this->assertEquals(InvalidParameterValueException::CODE_DATA_INVALID, $e->getCode());
        }
    }
}
