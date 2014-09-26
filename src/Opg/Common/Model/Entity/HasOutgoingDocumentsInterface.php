<?php
namespace Opg\Common\Model\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Documents\OutgoingDocument;

/**
 * Interface HasOutgoingDocumentsInterface
 * @package Opg\Common\Model\Entity
 */
interface HasOutgoingDocumentsInterface
{

    /**
     * @return ArrayCollection
     */
    public function getOutgoingDocuments();

    /**
     * @param ArrayCollection $outgoingDocuments
     * @return HasOutgoingDocumentsInterface
     */
    public function setOutgoingDocuments(ArrayCollection $outgoingDocuments);

    /**
     * @param OutgoingDocument $document
     * @return HasOutgoingDocumentsInterface
     */
    public function addOutgoingDocument(OutgoingDocument $document);
}
