<?php

namespace App\Module\Assignment\App\Data;

interface AutoAssignSpecificationInterface
{
    public function getIssueId(): ?int;
    public function getProjectId(): ?int;
}