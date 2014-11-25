<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 *
 * Class ReplacementAttorney
 * @package Opg\Core\Model\Entity\CaseActor
 */
class ReplacementAttorney extends AttorneyAbstract
{
    use ToArray;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var boolean
     * @Groups({"api-person-get"})
     */
    protected $isReplacementAttorney = false;

    public function __construct()
    {
        parent::__construct();
        $this->systemStatus = false;
    }

    /**
     * @return boolean $isReplacementAttorney
     */
    public function isReplacementAttorney()
    {
        return $this->isReplacementAttorney;
    }

    /**
     * @param boolean $isReplacementAttorney
     *
     * @return Attorney
     */
    public function setIsReplacementAttorney($isReplacementAttorney)
    {
        $this->isReplacementAttorney = $isReplacementAttorney;

        return $this;
    }
}
