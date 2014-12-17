<?php
namespace Opg\Core\Model\Entity\Note;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\Time;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\Assignable\User;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Doctrine\ORM\Mapping as ORM;
use \Zend\InputFilter\Factory as InputFactory;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;


/**
 * @ORM\Entity
 * @ORM\Table(name = "notes")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\NoteRepository")
 *
 * @package Opg Core
 */
class Note implements EntityInterface, \IteratorAggregate, HasIdInterface
{
    use Time;
    use \Opg\Common\Model\Entity\Traits\IteratorAggregate;
    use ToArray;
    use HasId;
    use InputFilter;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}, nullable = true)
     * @var int $sourceId
     */
    protected $sourceId;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $sourceTable
     */
    protected $sourceTable;

    /**
     * @ORM\Column(type = "string", nullable = false)
     * @var string $type
     */
    protected $type;

    /**
     * @ORM\ManyToOne(targetEntity = "Opg\Core\Model\Entity\Assignable\User")
     * @var User $user
     */
    protected $createdByUser;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string status
     */
    protected $status;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string description
     */
    protected $description;

    /**
     * @ORM\Column(type = "string", nullable = false)
     * @var string
     */
    protected $name;

    /**
     * @return Note $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function __construct()
    {
        $this->setCreatedTime();
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
     * @param User $createdByUser
     *
     * @return Note
     */
    public function setCreatedByUser(User $createdByUser)
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    /**
     * @param string $status
     *
     * @return Note
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string $description
     *
     * @return Note
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Note
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $sourceId
     *
     * @return Note
     */
    public function setSourceId($sourceId)
    {
        $this->sourceId = (int)$sourceId;

        return $this;
    }

    /**
     * @return int
     */
    public function getSourceId()
    {
        return $this->sourceId;
    }

    /**
     * @param string $sourceTable
     *
     * @return Note
     */
    public function setSourceTable($sourceTable)
    {
        $this->sourceTable = (string)$sourceTable;

        return $this;
    }

    /**
     * @return string
     */
    public function getSourceTable()
    {
        return $this->sourceTable;
    }

    /**
     * @throws \Opg\Common\Exception\UnusedException
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'name',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 1,
                                    'max'      => 1000,
                                )
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'type',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'InArray',
                                'options' => array(
                                    'haystack' => array(
                                        'Application processing',
                                        'Appointment of new attorney',
                                        'Call',
                                        'Cancellation',
                                        'Confirmation',
                                        'Change of address',
                                        'Court amendment',
                                        'Disclaimer',
                                        'Document capture',
                                        'Email',
                                        'Investigation',
                                        'Imperfect application',
                                        'Letter',
                                        'LPA application received',
                                        'Objections',
                                        'Office copy',
                                        'Registration',
                                        'Rejected application',
                                        'Revocation'
                                    )
                                )
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
