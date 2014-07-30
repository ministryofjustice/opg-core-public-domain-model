<?php


namespace Opg\Core\Model\Entity\Assignable\Validation\Validator;


use Zend\Validator\AbstractValidator;

class TeamName extends AbstractValidator
{
    const NAME_TO_LONG     = 'nameTooLong';
    const MAX_LEN          = 255;

    /**
     * @var array
     */
    protected $messageTemplates = array(
        self::NAME_TO_LONG => 'The name cannot exceed 255 characters in length.'
    );


    /**
     * @param Team $team
     *
     * @return bool
     */
    public function isValid($team) {
        $this->setValue($team);

        $result = true;

        if (strlen(trim($team)) > self::MAX_LEN) {
            $this->error(self::NAME_TO_LONG);
            $result &= false;
        }

        return $result;
    }
}
