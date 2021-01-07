<?php

namespace App\Module\Issue\Domain\Service;

use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Strings;
use App\Module\Issue\Domain\Exception\InvalidIssueDataException;

class IssueDataSanitizer
{
    private const NAME_MAX_LENGTH = 255;
    private const DESCRIPTION_MAX_LENGTH = 1000;

    public const USER_ID_KEY = 'user_id';
    public const PROJECT_ID_KEY = 'project_id';

    /**
     * @param string $rawName
     * @return string
     * @throws InvalidIssueDataException
     */
    public static function sanitizeName(string $rawName): string
    {
        $name = Strings::trim($rawName);

        $nameLength = Strings::length($name);

        $nameMaxLength = self::NAME_MAX_LENGTH;
        if ($nameLength === 0 || $nameLength > $nameMaxLength)
        {
            throw new InvalidIssueDataException("Name must have length from 1 to {$nameMaxLength}");
        }

        return $name;
    }

    /**
     * @param string|null $rawDescription
     * @return string|null
     * @throws InvalidIssueDataException
     */
    public static function sanitizeDescription(?string $rawDescription): ?string
    {
        if ($rawDescription === null)
        {
            return null;
        }

        $description = Strings::trim($rawDescription);

        $descriptionLength = Strings::length($description);

        $descriptionMaxLength = self::DESCRIPTION_MAX_LENGTH;
        if ($descriptionLength === 0 || $descriptionLength > $descriptionMaxLength)
        {
            throw new InvalidIssueDataException("Description must have length from 1 to {$descriptionMaxLength}");
        }

        return $description;
    }

    /**
     * @param array $fields
     * @return int
     * @throws InvalidIssueDataException
     */
    public static function sanitizeUserId(array &$fields): ?int
    {
        $userId = Arrays::get($fields, self::USER_ID_KEY);

        Arrays::removeByKey($fields, self::USER_ID_KEY);

        if ($userId === null)
        {
            return null;
        }

        if (!ctype_digit((string) $userId))
        {
            throw new InvalidIssueDataException('User id must be int');
        }

        return $userId;
    }

    /**
     * @param array $fields
     * @return int
     * @throws InvalidIssueDataException
     */
    public static function sanitizeProjectId(array &$fields): int
    {
        $projectId = Arrays::get($fields, self::PROJECT_ID_KEY);

        if ($projectId === null || !ctype_digit((string) $projectId))
        {
            throw new InvalidIssueDataException('No project id provided or it`s invalid', ['project_id' => $projectId]);
        }

        Arrays::removeByKey($fields, self::PROJECT_ID_KEY);

        return $projectId;
    }
}