<?php

namespace App\Module\Project\Api\Input;

use App\Module\Project\App\Request\CreateProjectRequestInterface;

class CreateProjectInput implements CreateProjectRequestInterface
{
    private string $name;
    private string $nameId;
    private int $ownerId;
    private ?string $description;

    public function __construct(string $name, string $nameId, int $userId, ?string $description)
    {
        $this->name = $name;
        $this->nameId = $nameId;
        $this->ownerId = $userId;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getNameId(): string
    {
        return $this->nameId;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}