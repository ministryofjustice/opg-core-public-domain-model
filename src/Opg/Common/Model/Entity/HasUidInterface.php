<?php

namespace Opg\Common\Model\Entity;

interface HasUidInterface
{
    /**
     * @param integer $uid
     * @return void
     */
    public function setUid($uid);

    /**
     * @return integer|null
     */
    public function getUid();
}