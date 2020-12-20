<?php

namespace App\Module\Project\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Project\Api\Output\TeamMemberListOutput;
use App\Module\Project\Api\Output\TeamMemberOutput;
use App\Module\Project\App\Data\TeamMemberData;

class TeamMemberMapper
{
    /**
     * @param TeamMemberData[] $list
     * @return TeamMemberListOutput
     */
    public static function getList(array $list): TeamMemberListOutput
    {
        return new TeamMemberListOutput((array) Arrays::map($list,
            static fn(TeamMemberData $data) => new TeamMemberOutput(
                $data->getId(),
                $data->getUserId(),
                $data->getUsername()
            )
        ));
    }
}