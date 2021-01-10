export default class CreateFieldStore
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async addField(props)
    {
        const response = await this._serverApi.addField(props);

        if(response)
        {
            this._name = props.name;
            this._type = props.type;
            this._fieldId = response.issue_field_id;
            return response;
        }
    }
}