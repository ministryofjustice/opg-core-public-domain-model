<?php
namespace Opg\Core\Listener;

use Opg\Core\Model\Entity\User\User;

/**
 * This interface can be implemented by services which provide the
 * identity of the acting user.
 * @codeCoverageIgnore
 * These are covered by tests in the backend and will be moved over
 */
interface UserIdentityProvider
{
    /**
     * Returns the user identity as a string.
     *
     * @return User
     */
    public function getUserIdentity();
}
