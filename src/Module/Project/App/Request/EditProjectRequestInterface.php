<?php

namespace App\Module\Project\App\Request;

interface EditProjectRequestInterface
{
    public function getId(): int;
    public function getOwnerId(): int;
    public function getNewOwnerId(): ?int;
    public function getName(): ?string;
    public function getDescription(): ?string;
}