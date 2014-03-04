<?php
namespace Opg\Common\Model\Entity\Traits;

/**
 * Class Time
 * 
 */
trait Time {

    /**
     * @var string createdTime
     */
    private $createdTime;
    
    /**
     * @return string $createdTime
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param string $createdTime A string that can be parsed by strtotime
     */
    public function setCreatedTime($createdTime)
    {
        $timestamp = strtotime($createdTime);
        
        $this->createdTime = date('Y-m-d\TH:i:s', $timestamp);
    }
}
