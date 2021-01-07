<?php

namespace App\Module\Project\Api\Mapper;

use App\Common\Domain\Utils\Arrays;
use App\Module\Project\Api\Output\TeamMemberListOutput;
use App\Module\Project\Api\Output\TeamMemberOutput;
use App\Module\Project\Api\Output\UserToAddToTeamOutput;
use App\Module\Project\App\Data\TeamMemberData;
use App\Module\Project\App\Data\UserToAddToTeamData;

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

    /**
     * @param UserToAddToTeamData[] $users
     * @return UserToAddToTeamOutput[]
     */
    public static function getUsersToAddToTeam(array $users): array
    {
        return (array) Arrays::map(
            $users,
            static fn(UserToAddToTeamData $user) => new UserToAddToTeamOutput(
                $user->getUserId(),
                $user->getUsername()
            )
        );
    }
}