export default class CreateCommentStore
{
 
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async addComment(props)
    {
        const response = await this._serverApi.createComment(props);

        if(response)
        {
            return response;
        }
    }
}