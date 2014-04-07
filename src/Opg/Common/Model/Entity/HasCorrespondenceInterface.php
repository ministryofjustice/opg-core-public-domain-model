<?php

namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Correspondence\Correspondence as CorrespondenceEntity;

interface HasCorrespondenceInterface
{

    /**
     * @return ArrayCollection|null
     */
    public function getCorrespondence();

    /**
     * @param  ArrayCollection $correspondence
     * @return ArrayCollection|null
     */
    public function setCorrespondence(ArrayCollection $correspondence);

    /**
     * @param NoteEntity $note
     * @return $this
     */
    public function addCorrespondence(CorrespondenceEntity $correspondence);

}