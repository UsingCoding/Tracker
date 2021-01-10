export default class MemberStore
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async addMember(props)
    {
        const response = await this._serverApi.addMember(props);

        if(response)
            return await response;
    }

    async removeMember(team_member_id)
    {
        const response = await this._serverApi.removeMember(team_member_id);

        if(response)
            return await response;
    }
}