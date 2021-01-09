export default class CommentsListStore
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async getComments(issue_id)
    {
        const response = await this._serverApi.getCommentsForIssue(issue_id);

        if(response)
            return response;
    } 
}