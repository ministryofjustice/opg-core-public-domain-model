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
    use ToArray;

    /**
     * @var EntityInterface
     */
    private $data;

    /**
     * @param $data
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $data
     *
     * @return Response
     */
    public function setJsonData($data)
    {
        $this->setData(
            json_decode($data)
        );

        return $this;
    }

    /**
     * @return EntityInterface
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return Response
     */
    public function exchangeArray(array $data)
    {
        empty($data['data'])?: $this->setData($data['data']);

        return $this;
    }

}
