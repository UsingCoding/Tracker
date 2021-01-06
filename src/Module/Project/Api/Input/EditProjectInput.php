<?php

namespace App\Module\Project\Api\Input;

use App\Module\Project\App\Request\EditProjectRequestInterface;

class EditProjectInput implements EditProjectRequestInterface
{
    private int $id;
    private int $ownerId;
    private ?int $newOwnerId;
    private ?string $name;
    private ?string $description;

    public function __construct(int $id, int $ownerId, ?int $newOwnerId, ?string $name, ?string $description)
    {
        $this->id = $id;
        $this->ownerId = $ownerId;
        $this->newOwnerId = $newOwnerId;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOwnerId(): int
    {
        return $this->ownerId;
    }

    /**
     * @return int|null
     */
    public function getNewOwnerId(): ?int
    {
        return $this->newOwnerId;
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
}