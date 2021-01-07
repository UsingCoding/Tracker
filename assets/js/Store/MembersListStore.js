export default class MembersListStore
{
    _memberList = null;

    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async getMembersList(project_id)
    {
        let response = await this._serverApi.getMembersList(project_id);

        if(response){
            this._memberList = await response;
            return this._memberList;
        }
    }

    async getUsersToAddList(project_id)
    {
        let response = await this._serverApi.getUsersToAddList(project_id);

        if(response){
            return response;
        }
    }
    
    get memberList()
    {
        return this._memberList;
    }
}