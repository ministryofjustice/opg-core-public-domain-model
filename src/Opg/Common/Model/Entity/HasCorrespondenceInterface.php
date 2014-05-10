<?php
namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Correspondence\Correspondence as CorrespondenceEntity;

/**
 * Interface HasCorrespondenceInterface
 * @package Opg\Common\Model\Entity
 */
interface HasCorrespondenceInterface
{

    /**
     * @return ArrayCollection|null
     */
    public function getCorrespondence();

    /**
     * @param  ArrayCollection $correspondence
     *
     * @return ArrayCollection|null
     */
    public function setCorrespondence(ArrayCollection $correspondence);

    /**
     * @param CorrespondenceEntity $correspondence
     *
     * @return $this
     */
    public function addCorrespondence(CorrespondenceEntity $correspondence);
}
