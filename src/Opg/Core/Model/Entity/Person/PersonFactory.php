<?php
namespace Opg\Core\Model\Entity\Person;

use JMS\Serializer\Serializer;

class PersonFactory
{
    public static function create(array $data, Serializer $serializer)
    {
        $personType = null;
        //@Todo once we have implemented this properly, remove this failsafe
        $data['personType'] = (isset($data['personType'])) ? $data['personType'] : 'Donor';

        if(!empty($data['personType'])) {
            switch ($data['personType']) {
                case "Attorney" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Attorney";
                     break;
                case "CertificateProvider" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\CertificateProvider";
                    break;
                case "NotifiedPerson" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\NotifiedPerson";
                    break;
                case "Correspondent" :
                    $personType = "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Correspondent";
                    break;
                default:
                    $personType = "Opg\\Core\\Model\\Entity\\CaseItem\\Lpa\\Party\\Donor";
                    break;
            }
        }
        else {
            throw new \Exception('Cannot build unknown person type.');
        }

        return
            $serializer->deserialize(
                json_encode($data),
                $personType,
                'json'
            );
    }
}
