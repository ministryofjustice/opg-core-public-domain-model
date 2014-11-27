<?php

namespace Opg\Core\Model\Entity\CaseActor\Interfaces;

/**
 * Interface HasNoticeGivenDate
 * @package Opg\Core\Model\Entity\CaseActor\Interfaces
 */
interface HasNoticeGivenDate
{
    /**
     * @param \DateTime $noticeGivenDate
     * @return HasNoticeGivenDate
     */
    public function setNoticeGivenDate(\DateTime $noticeGivenDate = null);

    /**
     * @return \DateTime
     */
    public function getNoticeGivenDate();
}
