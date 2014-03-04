<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\HowAttorneysAct;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\PaymentMethod;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\ApplicantCollection;

class LpaFilter extends InputFilter
{
    /**
     * @var Zend\InputFilter\Factory
     */
    private $inputFactory;

    public function __construct()
    {
        $this->inputFactory = new InputFactory();
        
        $this->setValidators();
    }
    
    private function setValidators()
    {
        $this->setCaseIdValidator();
        $this->setStatusValidator();
        $this->setDonorValidator();
        $this->setCorrespondentValidator();
        $this->setApplicantCollectionValidator();
        $this->setAttorneyCollectionValidator();
        $this->setCertificateProviderCollectionValidator();
        $this->setNotifiedPersonCollectionValidator();
        $this->setPaymentMethodValidator();
        $this->setHowAttorneysActValidator();
        $this->setHowReplacementAttorneysActValidator();
    }
    
    private function setCaseIdValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'caseId',
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
                                'min'      => 5,
                                'max'      => 24,
                            ),
                        )
                    )
                )
            )
        );
    }

    private function setStatusValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'status',
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
                                'min'      => 5,
                                'max'      => 24,
                            ),
                        )
                    )
                )
            )
        );
    }
    
    private function setDonorValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'donor',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor',
                            ),
                        )
                    )
                )
            )
        );
    }
    
    private function setCorrespondentValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'correspondent',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent',
                            ),
                        )
                    )
                )
            )
        );
    }
    
    private function setApplicantCollectionValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'applicantCollection',
                    'required'   => true,
                    'validators' => array(
                        new \Zend\Validator\Callback(
                            array(
                                'callback' => function ($value) {
                                    
                                    $applicantCollection =
                                        new \Opg\Core\Model\Entity\CaseItem\Lpa\Party\ApplicantCollection();
                                    $applicantCollection->exchangeArray($value);
                                                                        
                                    $isValid = $applicantCollection->isValid();

                                    return $isValid;
                                }
                            )
                        )
                    )
                )
            )
        );
    }
    
    private function setAttorneyCollectionValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'attorneyCollection',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyCollection',
                            ),
                        ),
                    ),
                )
            )
        );
    }
    
    private function setCertificateProviderCollectionValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'certificateProviderCollection',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProviderCollection',
                            ),
                        )
                    )
                )
            )
        );
    }
    
    private function setNotifiedPersonCollectionValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'notifiedPersonCollection',
                    'required'   => true,
                    'validators' => array(
                        array(
                            'name'    => 'IsInstanceOf',
                            'options' => array(
                                'className' => 'Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPersonCollection',
                            ),
                        )
                    )
                )
            )
        );
    }

    private function setPaymentMethodValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'paymentMethod',
                    'required'   => true,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        new PaymentMethod(),
                    )
                )
            )
        );
    }
    
    private function setHowAttorneysActValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'howAttorneysAct',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        new HowAttorneysAct(),
                    )
                )
            )
        );
    }
    
    private function setHowReplacementAttorneysActValidator()
    {
        $this->add(
            $this->inputFactory->createInput(
                array(
                    'name'       => 'howReplacementAttorneysAct',
                    'required'   => false,
                    'filters'    => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        new HowAttorneysAct(),
                    )
                )
            )
        );
    }
}
