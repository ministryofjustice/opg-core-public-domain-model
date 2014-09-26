<?php

namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Documents\IncomingDocument;

/**
 * Interface HasDocumentsInterface
 * @package Opg\Common\Model\Entity
 */
interface HasIncomingDocumentsInterface
{
    /**
     * @return ArrayCollection
     */
    public function getIncomingDocuments();

    /**
     * @param IncomingDocument $document
     * @return HasIncomingDocumentsInterface
     */
    public function addIncomingDocument(IncomingDocument $document);

    /**
     * @param ArrayCollection $incomingDocuments
     * @return HasIncomingDocumentsInterface
     */
    public function setIncomingDocuments(ArrayCollection $incomingDocuments);
}
