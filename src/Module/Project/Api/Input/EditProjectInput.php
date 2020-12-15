<?php

namespace App\Module\Project\Api\Input;

use App\Module\Project\App\Request\EditProjectRequestInterface;

class EditProjectInput implements EditProjectRequestInterface
{
    private int $id;
    private ?string $name;
    private ?string $description;

    public function __construct(int $id, ?string $name, ?string $description)
    {
        $this->id = $id;
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