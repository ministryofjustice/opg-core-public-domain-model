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
    protected $data;

    /**
     * @var array
     */
    protected $additionalData;

    /**
     * @param $data
     *
     * @return Response
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param $additionalData
     *
     * @return Response
     */
    public function setAdditionalData($additionalData)
    {
        $this->additionalData = $additionalData;

        return $this;
    }


    /**
     * @param string $data
     * @param string $additionalData
     *
     * @return Response
     */
    public function setJsonData($data, $additionalData = null)
    {
        $this->setData(
            json_decode($data)
        );

        if (!is_null($additionalData)) {
            $this->setAdditionalData(
                json_decode($additionalData)
            );
        }

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
     * @return EntityInterface
     */
    public function getAdditionalData()
    {
        return $this->additionalData;
    }

}
