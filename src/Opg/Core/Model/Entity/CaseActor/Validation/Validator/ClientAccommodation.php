<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class ClientAccommodation
 * @package Opg\Core\Model\Entity\CaseActor\Validation\Validator
 */
class ClientAccommodation extends InArray
{
    static $clientAccommodation = array(
        "No Accommodation Type",
        "Council Rented",
        "Family Member/Friend's Home",
        "Supervised Sheltered",
        "House Association",
        "Hostel",
        "Hotel",
        "Health Service Patient",
        "LA Nursing Home",
        "NHS Accommodation",
        "No Fixed Address",
        "Private Nursing Home",
        "Own Home",
        "Other",
        "Private Hospital",
        "LA Part 3 Accommodation",
        "Registered Care Home",
        "Private Rented",
        "Private Residential Home",
        "Secure Hospital",
        "Supported Housing",
        "Supported Living",
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            self::$clientAccommodation
        );
    }
}
