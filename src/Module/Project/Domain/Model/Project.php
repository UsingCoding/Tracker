<?php

namespace App\Module\Project\Domain\Model;

class Project
{
    private ?int $id;
    private string $name;
    private string $nameId;
    private ?string $description;

    public function __construct(?int $id, string $name, string $nameId, ?string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->nameId = $nameId;
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $nameId
     */
    public function setNameId(string $nameId): void
    {
        $this->nameId = $nameId;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}