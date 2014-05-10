<?php
namespace Opg\Core\Model\Entity\PowerOfAttorney;

use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;

use Opg\Common\Exception\UnusedException;

/**
 * Class PowerOfAttorneyFactory
 * @package Opg\Core\Model\Entity\PowerOfAttorney
 */
class PowerOfAttorneyFactory
{
    /**
     *
     * @param array $data
     *
     * @throws UnusedException
     * @throws \Exception
     * @return PowerOfAttorney:NULL
     */
    public static function createPowerOfAttorney(array $data)
    {
        $poa     = null;
        $poaType = null;

        if (!empty($data['className'])) {
            if ($data['className'] === "Opg\\Core\\Model\\Entity\\Lpa\\Lpa") {
                $poaType = new Lpa();
                $poa     = $poaType->exchangeArray($data);
            } else {
                throw new UnusedException('Classname not found');
            }
        } else {
            throw new \Exception('Cannot build Power of Attorney of unknown type');
        }

        return $poa;
    }
}
