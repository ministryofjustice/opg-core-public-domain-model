<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Documents\Document;
use Opg\Core\Model\Entity\Documents\OutgoingDocument;

/**
 * Class HasOutgoingDocuments
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasOutgoingDocuments
{
    /**
     * @return ArrayCollection
     */
    public function getOutgoingDocuments()
    {
        if (is_null($this->documents)) {
            $this->documents = new ArrayCollection();
        }

        //This is passed as a closure as the ArrayCollection expects a pointer to a function
        //which it passes through to php internals
        return $this->documents->filter(
            function ($item) {
                return $item->getDirection() === Document::DIRECTION_OUTGOING;
            }
        );
    }

    /**
     * @param ArrayCollection $outgoingDocuments
     *
     * @return HasOutgoingDocuments
     */
    public function setOutgoingDocuments(ArrayCollection $outgoingDocuments)
    {
        $incomingDocuments = $this->getIncomingDocuments();

        $this->documents = clone $outgoingDocuments;

        foreach ($incomingDocuments->toArray() as $document) {
            $this->addIncomingDocument($document);
        }

        return $this;
    }

    /**
     * @param OutgoingDocument $document
     *
     * @return HasOutgoingDocuments
     */
    public function addOutgoingDocument(OutgoingDocument $document)
    {
        if (is_null($this->documents)) {
            $this->documents = new ArrayCollection();
        }

        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }
}
