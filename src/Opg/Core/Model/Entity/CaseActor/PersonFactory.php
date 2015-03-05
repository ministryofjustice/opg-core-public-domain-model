<?php
namespace Opg\Core\Model\Entity\CaseActor;

use JMS\Serializer\Serializer;
use Opg\Common\Model\Entity\FactoryInterface;
use Opg\Core\Model\Entity\LegalEntity\LegalEntity;
use Opg\Core\Model\Entity\Warning\Warning;

/**
 * Class PersonFactory
 * @package Opg\Core\Model\Entity\CaseActor
 * serializer to be mocked out
 */
class PersonFactory implements FactoryInterface
{
    /**
     * @param array      $data
     * @param Serializer $serializer
     * @return LegalEntity
     * @throws \Exception
     */
    public static function create(array $data, Serializer $serializer)
    {
        $personType = null;
        //@Todo once we have implemented this properly, remove this failsafe
        $data['personType'] = (isset($data['personType'])) ? $data['personType'] : 'Donor';

        if (!empty($data['personType'])) {
            switch ($data['personType']) {
                case "Attorney" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\Attorney";
                    break;
                case "ReplacementAttorney" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\ReplacementAttorney";
                    break;
                case "TrustCorporation" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\TrustCorporation";
                    break;
                case "CertificateProvider" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\CertificateProvider";
                    break;
                case "NotifiedPerson" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\NotifiedPerson";
                    break;
                case "Correspondent" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\Correspondent";
                    break;
                case "Donor" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\Donor";
                    break;
                case "NotifiedRelative" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\NotifiedRelative";
                    break;
                case "NotifiedAttorney" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\NotifiedAttorney";
                    break;
                case "PersonNotifyDonor" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\PersonNotifyDonor";
                    break;
                case "Client" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\Client";
                    break;
                case "Deputy" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\Deputy";
                    break;
                case "FeePayer" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\FeePayer";
                    break;
                default:
                    $personType = "Opg\\Core\\Model\\Entity\\CaseActor\\NonCaseContact";
                    break;
            }
        } else {
            throw new \Exception('Cannot build unknown person type.');
        }

        // Try-Catch added due to https://github.com/schmittjoh/serializer/issues/216
        try {
            /** @var Person $person */
            $person = $serializer->deserialize(
                json_encode($data),
                $personType,
                'json'
            );

             //when a client is created for a Deputyship we set a warning against them
            if($personType == 'Opg\Core\Model\Entity\CaseActor\Client' && null == $person->getId()) {
                $warning = new Warning();
                $warning->setWarningText('Deputy Application-only');
                $warning->setWarningType('Deputy Application-only');
                $person->addWarning($warning);
            }

        } catch (\Exception $e) {
            throw $e;
        }

        return $person;
    }
}
