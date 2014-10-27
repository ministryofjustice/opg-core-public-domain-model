<?php

namespace Opg\Common\Model\Entity;

/**
 * Interface HasFinanceId
 * @package Opg\Common\Model\Entity\Traits
 */
interface HasSageId
{
    /**
     * @return HasSageId
     */
    public function getSageId();

    /**
     * @param string $sageId
     * @return HasSageId
     */
    public function setSageId($sageId);

    /**
     * @param  int $uid
     * @return string
     */
    public function generateSageId($uid);
}
