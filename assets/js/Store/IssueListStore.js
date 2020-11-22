import issueStore from "./IssueStore"

export default class IssueListStore
{
    _issueList = null;

    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async getIssueList()
    {
        let response = await this._serverApi.getIssueList();

        if(response){
            this._issueList = await response;
            return this._issueList;
        }
    }
    
    get issueList()
    {
        return this._issueList;
    }
}