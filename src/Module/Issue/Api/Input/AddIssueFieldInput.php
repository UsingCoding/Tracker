<?php

namespace App\Module\Issue\Api\Input;

use App\Module\Issue\App\Data\AddIssueFieldRequestInterface;

class AddIssueFieldInput implements AddIssueFieldRequestInterface
{
    private string $name;
    private int $type;
    private int $projectId;

    public function __construct(string $name, int $type, int $projectId)
    {
        $this->name = $name;
        $this->type = $type;
        $this->projectId = $projectId;
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

    /**
     * @return int
     */
    public function getProjectId(): int
    {
        return $this->projectId;
    }
}