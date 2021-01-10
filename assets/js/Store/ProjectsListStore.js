export default class ProjectsListStore
{
    _projectsList = null;

    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async getProjectsList()
    {
        let response = await this._serverApi.getProjectsList();

        if(response){
            this._projectsList = response;
            return this._projectsList;
        }
    }

    get projectsList()
    {
        return this._projectsList;
    }
}