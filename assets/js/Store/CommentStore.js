export default class CommentStore
{
    _comment_id = null;

    _content = null;
    
    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async editComment(props)
    {
        const response = await this._serverApi.editComment(props);

        if(response)
        {
            return response;
        }
    }

    async deleteComment(comment_id)
    {
        const response = await this._serverApi.deleteComment(comment_id);

        if(response)
        {
            return response;
        }
    }
}