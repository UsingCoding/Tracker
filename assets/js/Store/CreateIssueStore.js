// import serverApi from "../Api/ServerApi";

export default class CreateIssueStore
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async createIssue(props)
    {
        const response = await this._serverApi.createIssue(props); 

        if(response)
            return await response.json().issue_id;
    }
}