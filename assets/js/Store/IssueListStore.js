import issueStore from "./IssueStore"

export default class IssueListStore
{
    _issueList = null;

    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async createIssueList()
    {
        let response = await this._serverApi.createIssueList(user_id);

        if(response)
            return await response.json();
    }
    
    get issueList()
    {
        return this._issueList;
    }
}