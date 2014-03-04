<?php
namespace Opg\Core\Model\Entity\CaseItem\Validation\Validator;

use Zend\Validator\AbstractValidator;

/**
 * Class CaseItemCollection
 * @package Opg\Core\Model\Entity\CaseItem\Validation\Validator
 */
class CaseItemCollection extends AbstractValidator
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
     * @param mixed $caseItemCollection
     *
     * @return bool
     */
    public function isValid(
        $caseItemCollection
    ) {
        $this->setValue($caseItemCollection);

        $caseItemCollectionCount = count($caseItemCollection);

        if ($caseItemCollectionCount == 0) {
            $this->error(self::NO_CASEITEMS_FOUND);
            return false;
        }

        return true;
    }
}
