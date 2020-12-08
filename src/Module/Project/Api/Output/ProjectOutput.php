<?php

namespace App\Module\Project\Api\Output;

class ProjectOutput
{
    private int $id;
    private string $name;
    private string $nameId;
    private ?string $description;

    /**
     * GetProjectOutput constructor.
     * @param int $id
     * @param string $name
     * @param string $nameId
     * @param string|null $description
     */
    public function __construct(int $id, string $name, string $nameId, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nameId = $nameId;
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
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
}