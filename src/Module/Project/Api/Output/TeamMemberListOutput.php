<?php

namespace App\Module\Project\Api\Output;

class TeamMemberListOutput
{
    /** @var TeamMemberOutput[] */
    private array $members;

    /**
     * TeamMemberListOutput constructor.
     * @param TeamMemberOutput[] $members
     */
    public function __construct(array $members)
    {
        $this->members = $members;
    }

    /**
     * @return TeamMemberOutput[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }
}