<?php

namespace App\Module\Issue\App\Data;

interface CreateIssueRequestInterface
{
    public function getName(): string;
    public function getDescription(): ?string;
    public function getFields(): array;
}