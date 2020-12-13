<?php

namespace App\Module\Issue\App\Query\Data;

class IssueFieldListItemData
{
    private int $id;
    private string $name;
    private int $type;

    public function __construct(int $id, string $name, int $type)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }
}