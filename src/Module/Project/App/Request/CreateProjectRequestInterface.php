<?php

namespace App\Module\Project\App\Request;

interface CreateProjectRequestInterface
{
    public function getName(): string;
    public function getNameId(): string;
    public function getOwnerId(): int;
    public function getDescription(): ?string;
}