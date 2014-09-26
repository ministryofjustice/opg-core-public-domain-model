<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Documents\Document;
use Opg\Core\Model\Entity\Documents\IncomingDocument;

/**
 * Class HasDocuments
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasIncomingDocuments
{
    /**
     * @param IncomingDocument $document
     *
     * @return HasIncomingDocuments
     */
    public function addIncomingDocument(IncomingDocument $document)
    {
        if (is_null($this->documents)) {
            $this->documents = new ArrayCollection();
        }

        if (!$this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $incomingDocuments
     *
     * @return HasIncomingDocuments
     */
    public function setIncomingDocuments(ArrayCollection $incomingDocuments)
    {
        $outgoingDocuments = $this->getOutgoingDocuments();
        $this->documents   = clone $incomingDocuments;

        foreach ($outgoingDocuments->toArray() as $item) {
            $this->addIncomingDocument($item);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIncomingDocuments()
    {
        if (is_null($this->documents)) {
            $this->documents = new ArrayCollection();
        }

        return $this->documents->filter(
            function ($item) {
                return $item->getDirection() === Document::DIRECTION_INCOMING;
            }
        );
    }
}
