<?php
namespace Opg\Common\Model\Entity\Traits;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Correspondence\Correspondence as CorrespondenceEntity;

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
 */
trait HasCorrespondence {

    /**
     * @return ArrayCollection|null
     */
    public function getCorrespondence() {
        return $this->correspondence;
    }

    /**
     * @param  ArrayCollection $notes
     * @return ArrayCollection|null
     */
    public function setCorrespondence(ArrayCollection $correspondence) {
        $this->correspondence = $correspondence;

        return $this;
    }

    /**
     * @param CorrespondenceEntity $correspondence
     * @return $this
     */
    public function addCorrespondence(CorrespondenceEntity $correspondence) {
        if (is_null($this->correspondence)) {
            $this->correspondence = new ArrayCollection();
        }

        if(!$this->correspondence->contains($correspondence)) {
            $this->correspondence->add($correspondence);
        }

        return $this;
    }



}
