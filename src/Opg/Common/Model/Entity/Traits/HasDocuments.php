<?php

namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\HasDocumentsInterface;
use Opg\Core\Model\Entity\Document\Document;

/**
 * Class HasDocuments
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasDocuments
{
    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\Document\Document", cascade={"persist"})
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @Groups({"api-person-get"})
     * @ReadOnly
     */
    protected $documents;

    protected function initDocuments()
    {
        if (is_null($this->documents)) {
            $this->documents = new ArrayCollection();
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getIncomingDocuments()
    {
        $this->initDocuments();
        return $this->getFilteredDocuments(Document::DIRECTION_INCOMING);
    }

    /**
     * @return ArrayCollection
     */
    public function getOutgoingDocuments()
    {
        $this->initDocuments();
        return $this->getFilteredDocuments(Document::DIRECTION_OUTGOING);
    }

    /**
     * @param int $filter
     * @return ArrayCollection
     */
    public function getDocuments($filter = null)
    {
        $this->initDocuments();

        if ($filter) {
            return $this->getFilteredDocuments($filter);
        }

        return $this->documents;
    }

    /**
     * @param ArrayCollection $documents
     * @return HasDocumentsInterface
     */
    public function setDocuments(ArrayCollection $documents)
    {
        $this->documents = new ArrayCollection();

        foreach ($documents as $document) {
            $this->addDocument($document);
        }

        return $this;
    }

    /**
     * @param Document $document
     * @return HasDocumentsInterface
     */
    public function addDocument(Document $document)
    {
        $this->initDocuments();

        if (false == $this->documents->contains($document)) {
            $this->documents->add($document);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $incomingDocuments
     * @return HasIncomingDocuments
     */
    public function setIncomingDocuments(ArrayCollection $incomingDocuments)
    {
        $outgoingDocuments = $this->getOutgoingDocuments();
        $this->documents   = clone $incomingDocuments;

        foreach ($outgoingDocuments->toArray() as $document) {
            $this->addDocument($document);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $outgoingDocuments
     * @return HasOutgoingDocuments
     */
    public function setOutgoingDocuments(ArrayCollection $outgoingDocuments)
    {
        $incomingDocuments = $this->getIncomingDocuments();

        $this->documents = clone $outgoingDocuments;

        foreach ($incomingDocuments->toArray() as $document) {
            $this->addDocument($document);
        }

        return $this;
    }

    /**
     * @param $directionalFilter
     * @return ArrayCollection
     */
    protected function getFilteredDocuments($directionalFilter)
    {
        return $this->documents->filter(
            function ($item) use($directionalFilter) {
                return $item->getDirection() === $directionalFilter;
            }
        );
    }


}
