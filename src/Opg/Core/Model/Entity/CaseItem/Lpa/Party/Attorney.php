<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\RelationshipToDonor;
use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Company;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Attorney extends BasePerson implements  PartyInterface, HasRelationshipToDonor
{
    use Company;
    use ToArray {
        toArray as traitToArray;
    }
    use ExchangeArray;
    use RelationshipToDonor;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $occupation;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $isTrustCorporation = false;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $isReplacementAttorney = false;

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
     * @return boolean $isTrustCorporation
     */
    public function isTrustCorporation()
    {
        return $this->isTrustCorporation;
    }

    /**
     * @param boolean $isTrustCorporation
     * @return Attorney
     */
    public function setIsTrustCorporation($isTrustCorporation)
    {
        $this->isTrustCorporation = $isTrustCorporation;
        return $this;
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
     * @return Attorney
     */
    public function setIsReplacementAttorney($isReplacementAttorney)
    {
        $this->isReplacementAttorney = $isReplacementAttorney;
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
                        'name'       => 'email',
                        'required'   => false,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 3,
                                    'max'      => 24,
                                ),
                            )
                        )
                    )
                )
            );

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
}
