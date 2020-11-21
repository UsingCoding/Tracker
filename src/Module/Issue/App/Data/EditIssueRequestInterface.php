<?php

namespace App\Module\Issue\App\Data;

interface EditIssueRequestInterface
{
    public function getId(): int;
    public function getName(): ?string;
    public function getDescription(): ?string;
}