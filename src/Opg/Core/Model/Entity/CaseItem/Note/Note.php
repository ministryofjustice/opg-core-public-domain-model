<?php
namespace Opg\Core\Model\Entity\CaseItem\Note;

use Opg\Core\Model\Entity\User\User;

/**
 *
 * @package Opg Core
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class Note
{
    use \Opg\Common\Model\Entity\Traits\Time;
    
    /**
     * @var string $id
     */
    private $id;
    
    /**
     * @var string $sourceId
     */
    private $sourceId;
    
    /**
     * @var string $type
     */
    private $type;

    /**
     * @var User $user
     */
    private $createdByUser;

    /**
     * @var string status
     */
    private $status;

    /**
     * @var string description
     */
    private $description;

    /**
     * @var string name
     */
    private $name;

    /**
     * @return the $sourceId
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

	/**
     * @param string $sourceId
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = $sourceId;
        return $this;
    }

	/**
     * @return the $type
     */
    public function getType()
    {
        return $this->type;
    }

	/**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

	public function __construct()
    {
        $this->setCreatedTime(date('Y-m-d H:i:s'));
    }
    
    /**
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User $createdByUser
     */
    public function getCreatedByUser()
    {
        return $this->createdByUser;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $id
     * @return Note
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param User $createdByUser
     * @return Note
     */
    public function setCreatedByUser(User $createdByUser)
    {
        $this->createdByUser = $createdByUser;
        return $this;
    }

    /**
     * @param string $status
     * @return Note
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param string $description
     * @return Note
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * @param string $name
     * @return Note
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $data = get_object_vars($this);

        if (!empty($data['createdByUser'])) {
            $data['createdByUser'] = $data['createdByUser']->getArrayCopy();
        }

        return $data;
    }
}
