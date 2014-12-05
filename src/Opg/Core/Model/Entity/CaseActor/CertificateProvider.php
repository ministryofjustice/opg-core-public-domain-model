<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseActor\Decorators\RelationshipToDonor;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasRelationshipToDonor;
use Opg\Core\Model\Entity\CaseActor\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\Factory as InputFactory;
use Zend\Validator\Callback;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 *
 * @package Opg Domain Model
 *
 */
class CertificateProvider extends BasePerson implements HasRelationshipToDonor
{
    use ToArray;
    use RelationshipToDonor;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-person-get")
     */
    protected $certificateProviderStatementType;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-person-get")
     */
    protected $statement;


    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-person-get")
     */
    protected $certificateProviderSkills;

    /**
     * @return string $certificateProviderStatementType
     */
    public function getCertificateProviderStatementType()
    {
        return $this->certificateProviderStatementType;
    }

    /**
     * @param string $certificateProviderStatementType
     *
     * @return CertificateProvider
     */
    public function setCertificateProviderStatementType(
        $certificateProviderStatementType
    ) {
        $this->certificateProviderStatementType = $certificateProviderStatementType;

        return $this;
    }

    /**
     * @return string $statement
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param string $statement
     *
     * @return CertificateProvider
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;

        return $this;
    }

    /**
     * @param string $certificateProviderSkills
     *
     * @return CertificateProvider
     */
    public function setCertificateProviderSkills($certificateProviderSkills)
    {
        $this->certificateProviderSkills = $certificateProviderSkills;

        return $this;
    }

    /**
     * @return string
     */
    public function getCertificateProviderSkills()
    {
        return $this->certificateProviderSkills;
    }


    /**
     * @return InputFilterInterface
     * @codeCoverageIgnore
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();

            $factory = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'cases',
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

            $this->inputFilter->merge($inputFilter);
        }

        return $this->inputFilter;
    }
}
