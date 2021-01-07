<?php

namespace App\Module\Issue\Infrastructure\Query;

use App\Common\Domain\Utils\Arrays;
use App\Common\Domain\Utils\Strings;
use App\Module\Issue\App\Exception\SearchQueryParsingException;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Log\LoggerInterface;

class SearchQueryParser
{
    private const KEY_POSTFIX = ':';
    private const VALUE_REG = '({(.+)})';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $query
     * @param QueryBuilder $queryBuilder
     * @throws SearchQueryParsingException
     */
    public function parse(string $query, QueryBuilder $queryBuilder): void
    {
        // Assignee: {vadim.makerov} State: {} field: {value} Sort-by: UpdateTime DESC

        /** @var string[] $tokens */
        $tokens = Strings::split($query, ' ');

        $searchFields = [];
        $searchModifications = [];

        for ($i = 0; $i < Arrays::length($tokens); $i++)
        {
            $value = $tokens[$i];

            if (Strings::isEndsWith($value, self::KEY_POSTFIX))
            {
                $sanitizedKey = Strings::lower(Strings::substr($value, 0, Strings::length($value) - 1));

                $matches = [];

                if ((bool) preg_match(self::VALUE_REG, $tokens[$i + 1], $matches))
                {
                    $preparedKey = $sanitizedKey;

                    $preparedKey = SearchQueryKeyWords::getMappedNameByKeyWord($preparedKey);

                    $queryBuilder->where("$preparedKey = $value");

                    $i++;
                    continue;
                }

                if (Arrays::hasKey(SearchQueryKeyWords::MODIFICATION_KEY_WORDS, $value))
                {
                    if ($value === SearchQueryKeyWords::GROUP_BY)
                    {
                        $queryBuilder->groupBy($sanitizedKey);
                    }
                }

                throw new SearchQueryParsingException(SearchQueryParsingException::KEY_FOUNDED_BUT_VALUE_IS_NOT_SUPPORTED);
            }
        }
    }
}