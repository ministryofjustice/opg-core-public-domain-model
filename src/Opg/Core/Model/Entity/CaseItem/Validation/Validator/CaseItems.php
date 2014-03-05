<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class CaseItems
 * @package Opg\Core\Model\Entity\CaseItem\Validation\Validator
 * @todo Figure out where to put this, currently is validating in CaseItem.php
 */
class CaseItems extends AbstractValidator
{
    const NO_CASEITEMS_FOUND       = 'noCaseItemsFound';

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::NO_CASEITEMS_FOUND =>
            'There must be at least one CaseItem'
    );


    /**
     * @param mixed $caseItems
     *
     * @return bool
     */
    public function isValid(
        $caseItems
    ) {
        $this->setValue($caseItems);

        $caseItemCount = count($caseItems);

        if ($caseItemCount == 0) {
            $this->error(self::NO_CASEITEMS_FOUND);
            return false;
        }

        return true;
    }
}
