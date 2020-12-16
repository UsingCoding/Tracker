<?php

namespace App\Module\Project\App\Request;

interface AddTeamMemberRequestInterface
{
    public function getProjectId(): int;
    public function getUserId(): int;
}