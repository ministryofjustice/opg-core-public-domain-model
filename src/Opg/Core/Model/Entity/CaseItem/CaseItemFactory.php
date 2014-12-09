<?php

namespace Opg\Core\Model\Entity\CaseItem;

use JMS\Serializer\Serializer;
use Opg\Common\Model\Entity\FactoryInterface;
use Opg\Core\Model\Entity\LegalEntity\LegalEntity;

/**
 * Class CaseItemFactory
 * @package Opg\Core\Model\Entity\CaseItem
 */
class CaseItemFactory implements FactoryInterface
{
    /**
     * @param array      $data
     * @param Serializer $serializer
     * @return LegalEntity
     * @throws \Exception
     */
    public static function create(array $data, Serializer $serializer)
    {
        $caseType = null;
        $data['caseType'] = (isset($data['caseType'])) ? $data['caseType'] : 'Lpa';

        if (!empty($data['caseType'])) {
            switch ($data['caseType']) {
                case "Epa" :
                    $caseType = "Opg\\Core\\Model\\Entity\\CaseItem\\PowerOfAttorney\\Epa";
                    break;
                case "Order" :
                    $caseType = "Opg\\Core\\Model\\Entity\\CaseItem\\Deputyship\\Order";
                    break;
                default:
                    $caseType = "Opg\\Core\\Model\\Entity\\CaseItem\\PowerOfAttorney\\Lpa";
                    break;
            }
        } else {
            throw new \Exception('Cannot build unknown case type.');
        }

        try {
            /** @var CaseItem $case */
            $case = $serializer->deserialize(
                json_encode($data),
                $caseType,
                'json'
            );
        } catch (\Exception $e) {
            $case = null;
            throw $e;
        }

        return $case;
    }
}
