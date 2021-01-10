export default class ProjectFieldsListStore
{
    _fieldsList = null;

    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async getFieldsList(projectId)
    {
        let response = await this._serverApi.getFieldsList(projectId);

        if(response){
            this._fieldsList = response;
            return this._fieldsList;
        }
    }

    get fieldsList()
    {
        return this._fieldsList;
    }
}