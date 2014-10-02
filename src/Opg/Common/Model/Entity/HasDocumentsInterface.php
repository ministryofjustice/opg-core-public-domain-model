<?php

namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Documents\Document;

/**
 * Interface HasDocumentsInterface
 * @package Opg\Common\Model\Entity
 */
interface HasDocumentsInterface
{
    /**
     * @return ArrayCollection
     */
    public function getIncomingDocuments();

    /**
     * @return ArrayCollection
     */
    public function getOutgoingDocuments();

    /**
     * @param int $filter (One of the Document direction constants)
     * @return ArrayCollection
     */
    public function getDocuments($filter = null);

    /**
     * @param ArrayCollection $documents
     * @return HasDocumentsInterface
     */
    public function setDocuments(ArrayCollection $documents);

    /**
     * @param Document $document
     * @return HasDocumentsInterface
     */
    public function addDocument(Document $document);

    /**
     * @param ArrayCollection $incomingDocuments
     * @return HasDocumentsInterface
     */
    public function setIncomingDocuments(ArrayCollection $incomingDocuments);

    /**
     * @param ArrayCollection $incomingDocuments
     * @return HasDocumentsInterface
     */
    public function setOutgoingDocuments(ArrayCollection $incomingDocuments);
}
