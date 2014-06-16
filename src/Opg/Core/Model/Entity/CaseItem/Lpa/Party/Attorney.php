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
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Attorney extends AttorneyAbstract implements PartyInterface, HasRelationshipToDonor
{
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
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpaPartCSignatureDateString",setter="setLpaPartCSignatureDateString")
     */
    protected $lpaPartCSignatureDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpa002SignatureDateString",setter="setLpa002SignatureDateString")
     */
    protected $lpa002SignatureDate;

    /**
     * @ORM\Column(type = "integer", nullable = true)
     * @var int
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
     *
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
                                    // @codeCoverageIgnoreStart
                                    'callback' => function () {
                                            return $this->hasAttachedCase();
                                        }
                                    // @codeCoverageIgnoreEnd
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
    public function toArray($exposeClassname = true)
    {
        return $this->traitToArray($exposeClassname);
    }

    /**
     * @param \DateTime $lpa002SignatureDate
     *
     * @return Attorney
     */
    public function setLpa002SignatureDate(\DateTime $lpa002SignatureDate = null)
    {
        $this->lpa002SignatureDate = $lpa002SignatureDate;

        return $this;
    }

    /**
     * @param string $lpa002SignatureDate
     *
     * @return Attorney
     */
    public function setLpa002SignatureDateString($lpa002SignatureDate)
    {
        if (!empty($lpa002SignatureDate)) {
            $result = OPGDateFormat::createDateTime($lpa002SignatureDate);
            if ($result) {
                return $this->setLpa002SignatureDate($result);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime $lpa002SignatureDate
     */
    public function getLpa002SignatureDate()
    {
        return $this->lpa002SignatureDate;
    }

    /**
     * @return string
     */
    public function getLpa002SignatureDateString()
    {
        if (!empty($this->lpa002SignatureDate)) {
            return $this->lpa002SignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param \DateTime $lpaPartCSignatureDate
     *
     * @return Attorney
     */
    public function setLpaPartCSignatureDate(\DateTime $lpaPartCSignatureDate = null)
    {
        $this->lpaPartCSignatureDate = $lpaPartCSignatureDate;

        return $this;
    }

    /**
     * @param string $lpaPartCSignatureDate
     *
     * @return Lpa
     */
    public function setLpaPartCSignatureDateString($lpaPartCSignatureDate)
    {
        if (!empty($lpaPartCSignatureDate)) {
            $result = OPGDateFormat::createDateTime($lpaPartCSignatureDate);
            if ($result) {
                return $this->setLpaPartCSignatureDate($result);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLpaPartCSignatureDate()
    {
        return $this->lpaPartCSignatureDate;
    }

    /**
     * @return string
     */
    public function getLpaPartCSignatureDateString()
    {
        if (!empty($this->lpaPartCSignatureDate)) {
            return $this->lpaPartCSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param int $isAttorneyApplyingToRegister
     *
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
