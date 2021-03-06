<?php

namespace App\Module\Issue\Api\Input;

use App\Module\Issue\App\Data\EditIssueRequestInterface;

class EditIssueInput implements EditIssueRequestInterface
{
    private int $id;
    private ?string $name;
    private ?string $description;
    private ?array $fields;

    public function __construct(int $id, ?string $name, ?string $description, ?array $fields)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->fields = $fields;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array|null
     */
    public function getFields(): ?array
    {
        return $this->fields;
    }
}