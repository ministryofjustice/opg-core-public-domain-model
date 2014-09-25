<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Correspondence\BaseCorrespondence as CorrespondenceEntity;

/**
 * Companion trait to the HasCorrespondenceInterface
 *
 * This trait is similar to hasNotes. The main difference is that
 * correspondence for now is created one correspondence at a time
 * there is a getter for getting all correspondence and an add to add one
 * correspodence at a time
 *
 * Note that this trait does not define "protected $correspondence;"
 * This is because each class which implements HasCorrespondenceInterface requires it's
 * own doctrine annotation to define the join table.
 * You will also need to initialise $correspondence to be an empty ArrayCollection in your constructor.
 * See the Person or CaseItem objects for examples.
 *
 * Class HasCorrespondence
 * @package Opg\Common\Model\Entity\Traits
 */
trait HasCorrespondence
{

    /**
     * @return ArrayCollection|null
     */
    public function getCorrespondence()
    {
        return $this->correspondence->filter(function($item){
                return $item->getDirection() === CorrespondenceEntity::DIRECTION_OUTGOING;
            }
        );
    }

    /**
     * @param ArrayCollection $correspondence
     *
     * @return $this
     */
    public function setCorrespondence(ArrayCollection $correspondence)
    {
        $documents = $this->getDocuments();

        $this->correspondence = $correspondence;

        foreach ($documents->toArray() as $document) {
            $this->addDocument($document);
        }
        return $this;
    }

    /**
     * @param CorrespondenceEntity $correspondence
     *
     * @return $this
     */
    public function addCorrespondence(CorrespondenceEntity $correspondence)
    {
        // @codeCoverageIgnoreStart
        if (is_null($this->correspondence)) {
            $this->correspondence = new ArrayCollection();
        }
        // @codeCoverageIgnoreEnd

        if (!$this->correspondence->contains($correspondence)) {
            $this->correspondence->add($correspondence);
        }

        return $this;
    }

    /**
     * @param CorrespondenceEntity $document
     * @return $this
     */
    public function addDocument(CorrespondenceEntity $document)
    {
        return $this->addCorrespondence($document);
    }

    /**
     * @param ArrayCollection $documents
     * @return HasCorrespondence
     */
    public function setDocuments(ArrayCollection $documents)
    {
        $correspondence = $this->getCorrespondence();
        $this->correspondence = $documents;

        foreach ($correspondence->toArray() as $item) {
            $this->addCorrespondence($item);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getDocuments()
    {
        return $this->correspondence->filter(function($item){
                return $item->getDirection() === CorrespondenceEntity::DIRECTION_INCOMING;
            }
        );
    }
}
