<?php


namespace App\Module\Issue\Api\Input;


use App\Module\Issue\App\Data\CreateIssueRequestInterface;

class CreateIssueInput implements CreateIssueRequestInterface
{
    private string $name;
    private ?string $description;
    private array $fields;

    public function __construct(string $name, ?string $description, array $fields)
    {
        $this->name = $name;
        $this->description = $description;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getName(): string
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
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}