<?php
namespace Opg\Core\Model\Entity\User;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Zend\InputFilter\InputFilter;
use Opg\Common\Exception\UnusedException;

/**
 * Class UserCollection
 *
 * @package Opg\Core\Model\Entity\User
 */
class UserCollection implements IteratorAggregate, CollectionInterface
{
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $userCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * @param array $data
     */
    public function exchangeArray(array $data)
    {
        throw new UnusedException();
    }

    /**
     * Alias for getUserCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getUserCollection();
    }

    /**
     * @return array
     */
    public function getUserCollection()
    {
        return $this->userCollection;
    }

    /**
     * @param UserInterface $user
     * @return UserCollection
     */
    public function addUser(User $user)
    {
        $this->userCollection[] = $user;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $results = array();
        
        foreach ($this->userCollection as $user) {
            $results[] = $user->getArrayCopy();
        }

        return $results;
    }
    
    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        return new InputFilter();
    }
}
