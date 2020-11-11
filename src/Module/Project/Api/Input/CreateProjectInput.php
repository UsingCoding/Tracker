<?php

namespace App\Module\Project\Api\Input;

class CreateProjectInput
{
    private string $name;
    private string $nameId;
    private string $description;

    public function __construct(string $name, string $nameId, string $description)
    {
        $this->name = $name;
        $this->nameId = $nameId;
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
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}