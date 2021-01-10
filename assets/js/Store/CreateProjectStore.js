export default class CreateProjectStore
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async createProject(props)
    {
        const response = await this._serverApi.createProject(props);

        if(response)
            return await response;
    }
}