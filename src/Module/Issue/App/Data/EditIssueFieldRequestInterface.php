<?php

namespace App\Module\Issue\App\Data;

interface EditIssueFieldRequestInterface
{
    public function getIssueFieldId(): int;
    public function getName(): ?string;
    public function getType(): ?int;
}