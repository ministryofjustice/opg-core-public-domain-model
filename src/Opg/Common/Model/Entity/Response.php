<?php
namespace Opg\Common\Model\Entity;

use Opg\Common\Model\Entity\Traits\IteratorAggregate as IteratorAggregateTrait;
use Opg\Common\Model\Entity\Traits\ToArray;

/**
 * Class Response
 *
 * @package Application\Model\Entity
 */
class Response implements \IteratorAggregate
{

    use IteratorAggregateTrait;
    use ToArray {
        toArray as traitToArray;
    }

    /**
     * @var EntityInterface
     */
    private $data;

    /**
     * @param EntityInterface $data
     * @return Response
     */
    public function setData(EntityInterface $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @return EntityInterface
     */
    public function getData()
    {
        return $this->data;
    }

    public function toArray() {
        $baseArray = $this->traitToArray();

        if (!empty($this->data)) {
            $baseArray['data'] = $baseArray['data']->toArray();
        }

        return $baseArray;
    }
}
