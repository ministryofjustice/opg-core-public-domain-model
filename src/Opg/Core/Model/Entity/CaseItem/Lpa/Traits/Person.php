<?php

/**
 * @package Opg Core Domain Model
 */

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Traits;

trait Person
{
    /**
     * @var string
     */
    protected $dob;
    
    /**
     * @var string
     */
    protected $title;
    
    /**
     * @var string
     */
    protected $firstname;
    
    /**
     * @var string
     */
    protected $middlenames;
    
    /**
     * @var string
     */
    protected $surname;
    
    /**
     * @return string $dob
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @param number $dob
     * @return PartyInterface
     */
    public function setDob($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PartyInterface
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return PartyInterface
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string $middlenames
     */
    public function getMiddlename()
    {
        return $this->middlenames;
    }

    /**
     * @param string $middlenames
     * @return PartyInterface
     */
    public function setMiddlename($middlenames)
    {
        $this->middlenames = $middlenames;
        return $this;
    }

    /**
     * @return string $surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return PartyInterface
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
        return $this;
    }
}
