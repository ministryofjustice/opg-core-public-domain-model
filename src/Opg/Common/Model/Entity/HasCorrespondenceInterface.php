<?php
namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Correspondence\BaseCorrespondence as CorrespondenceEntity;

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

    /**
     * @return ArrayCollection|null
     */
    public function getDocuments();

    /**
     * @param CorrespondenceEntity $document
     * @return HasCorrespondenceInterface
     */
    public function addDocument(CorrespondenceEntity $document);

    /**
     * @param ArrayCollection $documents
     * @return HasCorrespondenceInterface
     */
    public function setDocuments(ArrayCollection $documents);
}
