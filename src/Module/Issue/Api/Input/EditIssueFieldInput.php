<?php

namespace App\Module\Issue\Api\Input;

use App\Module\Issue\App\Data\EditIssueFieldRequestInterface;

class EditIssueFieldInput implements EditIssueFieldRequestInterface
{
    private int $issueFieldId;
    private ?string $name;
    private ?int $type;

    public function __construct(int $issueFieldId, ?string $name, ?int $type)
    {
        $this->issueFieldId = $issueFieldId;
        $this->name = $name;
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getIssueFieldId(): int
    {
        return $this->issueFieldId;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }
}