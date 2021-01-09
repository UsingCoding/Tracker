<?php

namespace App\Module\User\Domain\Service;

use App\Common\Domain\Utils\Strings;
use App\Module\User\Domain\Exception\InvalidUserDataException;

class UserDataSanitizer
{
    /**
     * @param string|null $rawEmail
     * @return string|null
     * @throws InvalidUserDataException
     */
    public static function sanitizeEmail(?string $rawEmail): ?string
    {
        if ($rawEmail === null)
        {
            return null;
        }

        $email = Strings::trim($rawEmail);

        if(!preg_match('/^.+@.+\.[a-z]+/', $email))
        {
            throw new InvalidUserDataException('', ['email' => $email]);
        }

        return $email;
    }
}