export default class ProjectStore
{
    _serverApi = null;

    _name = null;
    _nameId = null;
    _description = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async getProjectInfo(project_id)
    {
        const response = await this._serverApi.getProject(project_id);

        if(response)
        {   
            this._name = response.name;
            this._nameId = response._nameId;
            this._description = response._description;
        }
        return response;
    }

    async updateProject(props)
    {
        const response = await this._serverApi.updateProject(props);

        if(response)
        {
            this._name = props.name;
            this._nameId = props.nameId;
            this._description = props._description;
        }
        return response;
    }

    async deleteProject(project_id)
    {
        const response = await this._serverApi.deleteProject(project_id);
        
        if(response)
            return response;
    }
}