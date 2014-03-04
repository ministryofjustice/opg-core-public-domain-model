<?php
namespace Opg\Common\Model\Entity;

use IteratorAggregate;
use Opg\Common\Model\Entity\Traits\IteratorAggregate as IteratorAggregateTrait;
use Opg\Common\Model\Entity\Traits\ToArray as ToArrayTrait;

/**
 * Class ResponseCollection
 *
 * @package Opg\Common\Model\Entity
 */
class ResponseCollection implements \IteratorAggregate
{

    use ToArrayTrait;
    use IteratorAggregateTrait;

    /**
     * @var CollectionInterface
     */
    private $data;

    /**
     * @var int
     */
    private $total;

    /**
     * @param CollectionInterface $data
     * @return Response
     */
    public function setData(CollectionInterface $data)
    {
        $this->setTotal(count($data->getData()));
        $this->data = $data;

        return $this;
    }

    /**
     * @return CollectionInterface
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     * @return Response
     */
    public function setTotal($total)
    {
        $this->total = (int)$total;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $cleanData = [];

        if (!empty($this->data)) {
            $nullInfestedData = $this->data->toArray();

            $cleanData = $this->cleanNull($nullInfestedData);
        }

        $result = [
            'data'  => ($this->data ? $cleanData : []),
            'total' => $this->getTotal(),
        ];

        return $result;
    }

    /**
     * Recursively unsets null values from nested arrays
     * @param array $arr
     * @return array
     */
    private function cleanNull(array $arr)
    {
        foreach ($arr as $key => $val) {
            if (null === $val) {
                unset($arr[$key]);
            }
            if (is_array($val)) {
                // Recurse array
                $arr[$key] = $this->cleanNull($val);
            }
        }

        return $arr;
    }
}
