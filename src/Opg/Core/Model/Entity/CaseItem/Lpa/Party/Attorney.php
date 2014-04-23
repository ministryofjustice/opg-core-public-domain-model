<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Attorney extends AttorneyAbstract implements  PartyInterface, HasRelationshipToDonor
{
    use ToArray {
        toArray as traitToArray;
    }
    use ExchangeArray;
    use RelationshipToDonor;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $occupation;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $lpaPartCSignatureDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $lpa002SignatureDate;

    /**
     * @ORM\Column(type = "integer", nullable = true)
     * @var int
     * @Type("integer")
     */
    protected $isAttorneyApplyingToRegister = self::OPTION_NOT_SET;

    /**
     * @return string $occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     * @return Attorney
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
        return $this;
    }

    /**
     * @return void|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'powerOfAttorneys',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                        //@Todo figure out why the default is_empty message is displaying
                                        Callback::INVALID_VALUE    => 'This person needs an attached case',
                                        Callback::INVALID_CALLBACK => "An error occurred in the validation"
                                    ),
                                    'callback' => function () {
                                            return $this->hasAttachedCase();
                                        }
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

    /**
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = TRUE) {
        return $this->traitToArray($exposeClassname);
    }

    /**
     * @param string $lpa002SignatureDate
     * @return Attorney
     */
    public function setLpa002SignatureDate($lpa002SignatureDate)
    {
        $this->lpa002SignatureDate = $lpa002SignatureDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getLpa002SignatureDate()
    {
        return $this->lpa002SignatureDate;
    }

    /**
     * @param string $lpaPartCSignatureDate
     * @return Attorney
     */
    public function setLpaPartCSignatureDate($lpaPartCSignatureDate)
    {
        $this->lpaPartCSignatureDate = $lpaPartCSignatureDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getLpaPartCSignatureDate()
    {
        return $this->lpaPartCSignatureDate;
    }

    /**
     * @param int $isAttorneyApplyingToRegister
     * @return Attorney
     */
    public function setIsAttorneyApplyingToRegister($isAttorneyApplyingToRegister = self::OPTION_FALSE)
    {
        $this->isAttorneyApplyingToRegister = $isAttorneyApplyingToRegister;
        return $this;
    }

    /**
     * @return int
     */
    public function getIsAttorneyApplyingToRegister()
    {
        return $this->isAttorneyApplyingToRegister;
    }


}
