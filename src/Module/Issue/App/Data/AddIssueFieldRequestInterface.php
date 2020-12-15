<?php

namespace App\Module\Issue\App\Data;

interface AddIssueFieldRequestInterface
{
    public function getName(): string;
    public function getType(): int;
    public function getProjectId(): int;
}