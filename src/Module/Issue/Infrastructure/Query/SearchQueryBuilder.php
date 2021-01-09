<?php

namespace App\Module\Issue\Infrastructure\Query;

use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Strings;
use App\Common\Infrastructure\Persistence\OrderByType;
use App\Module\Issue\App\Exception\SearchQueryParsingException;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Log\LoggerInterface;

class SearchQueryBuilder
{
    private const KEY_POSTFIX = ':';
    private const VALUE_REG = '({(.+)})';

    private const DEFAULT_ORDER_TYPE = OrderByType::DESC;

    private const RESERVED_PARAMS = [
        SearchQueryKeyWords::ASSIGNEE,
        SearchQueryKeyWords::ORDER_BY
    ];

    private const AVAILABLE_SORT_BY_PARAMS = [
        IssueTable::CREATED_AT,
        IssueTable::UPDATED_AT
    ];

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $searchQuery
     * @param QueryBuilder $queryBuilder
     * @throws SearchQueryParsingException
     */
    public function build(string $searchQuery, QueryBuilder $queryBuilder): void
    {
        /** @var string[] $tokens */
        $tokens = Strings::split($searchQuery, ' ');

        $searchModifiers = [];
        $fieldsSearches = [];

        for ($i = 0; $i < Arrays::length($tokens); $i++)
        {
            $token = $tokens[$i];

            if (Strings::isEndsWith($token, self::KEY_POSTFIX))
            {
                $token = $this->sanitizeKey($token);

                if (!Arrays::hasValue(self::RESERVED_PARAMS, $token))
                {
                    $this->proceedFieldsSearchParams($i, $token, $tokens[$i + 1], $fieldsSearches);

                    continue;
                }

                $this->proceedSearchParamsModification($i, $token, $tokens, $queryBuilder);

                continue;
            }

            $searchModifiers[] = $token;
        }

        if (Arrays::length($searchModifiers) !== 0)
        {
            $searchModifier = implode('%', $searchModifiers);

            $searchModifier = "%$searchModifier%";

            $queryBuilder
                ->andWhere($queryBuilder->expr()->like('i.name', ':search_modifier'))
                ->orWhere($queryBuilder->expr()->like('i.description', ':search_modifier'))
                ->setParameter('search_modifier', $searchModifier, ParameterType::STRING)
            ;
        }

        if (Arrays::length($fieldsSearches) !== 0)
        {
            foreach ($fieldsSearches as $key => $value)
            {
                $queryBuilder
                    ->andWhere($queryBuilder->expr()->eq("fields->>'$key'", ':' . $key . '_value'))
                    ->setParameter(':' . $key . '_value', $value, ParameterType::STRING)
                ;
            }
        }
    }

    /**
     * @param int $i
     * @param string $key
     * @param string $value
     * @param array $fieldsSearches
     * @throws SearchQueryParsingException
     */
    private function proceedFieldsSearchParams(int &$i, string $key, string $value, array &$fieldsSearches): void
    {
        $sanitizedValue = $this->sanitizeValue($value);

        $fieldsSearches[$key] = $sanitizedValue;

        $i++;
    }

    /**
     * @param int $i
     * @param string $key
     * @param array $tokens
     * @param QueryBuilder $queryBuilder
     * @throws SearchQueryParsingException
     */
    private function proceedSearchParamsModification(int &$i, string $key, array $tokens, QueryBuilder $queryBuilder): void
    {
        if ($key === SearchQueryKeyWords::ASSIGNEE)
        {
            $this->proceedAssigneeSearchModification($i, $tokens, $queryBuilder);
        }

        if ($key === SearchQueryKeyWords::ORDER_BY)
        {
            $this->proceedSortBySearchModification($i, $tokens, $queryBuilder);
        }
    }

    /**
     * @param int $i
     * @param array $tokens
     * @param QueryBuilder $queryBuilder
     * @throws SearchQueryParsingException
     */
    private function proceedAssigneeSearchModification(int &$i, array $tokens, QueryBuilder $queryBuilder): void
    {
        $username = $this->sanitizeValue($tokens[$i + 1]);

        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq('ac.username', ':username'))
            ->setParameter('username', $username, ParameterType::STRING)
        ;

        $i++;
    }

    /**
     * @param int $i
     * @param array $tokens
     * @param QueryBuilder $queryBuilder
     * @throws SearchQueryParsingException
     */
    private function proceedSortBySearchModification(int &$i, array $tokens, QueryBuilder $queryBuilder): void
    {
        $value = Strings::lower($this->sanitizeValue($tokens[$i + 1]));

        if (!Arrays::hasValue(self::AVAILABLE_SORT_BY_PARAMS, $value))
        {
            throw new SearchQueryParsingException(SearchQueryParsingException::UNKNOWN_ORDER_BY_PARAM);
        }


        if (Arrays::length($tokens) > $i + 2)
        {
            $order = $tokens[$i + 2];

            if ($order === Strings::lower(OrderByType::DESC) || $order === Strings::lower(OrderByType::ASC))
            {
                $queryBuilder
                    ->orderBy('i.' . $value, Strings::lower($order))
                ;

                $i += 2;

                return;
            }
        }

        $queryBuilder
            ->orderBy('i.' . $value, self::DEFAULT_ORDER_TYPE)
        ;

        $i++;
    }

    private function sanitizeKey(string $key): string
    {
        return Strings::lower(Strings::substr($key, 0, Strings::length($key) - 1));
    }

    /**
     * @param string $value
     * @return string
     * @throws SearchQueryParsingException
     */
    private function sanitizeValue(string $value): string
    {
        if (!(bool) preg_match(self::VALUE_REG, $value, $matches))
        {
            throw new SearchQueryParsingException(SearchQueryParsingException::VALUE_NOT_SUPPORTED);
        }

        return $matches[1];
    }
}