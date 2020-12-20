export default class FieldStore
{
    _name = null;

    _type = null;

    _fieldId = null;

    _serverApi = null;

    constructor(server_api)
    {
        this._serverApi = server_api;
    }

    async editField(props)
    {
        const response = await this._serverApi.editField(props);

        if(response)
        {
            return response;
        }
    }

    async deleteField(field_id)
    {
        const response = await this._serverApi.deleteField(field_id);

        if(response)
        {
            return response;
        }
    }
}