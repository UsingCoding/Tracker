export default class IssueStore
{
    _serverApi = null;

    _name = null;
    _description = null;
    _fields = null;
    _createdAt = null;
    _updatedAt = null;
    _comments = null;

    _isEditState = false;

    constructor(props = {})
    {
        this._name = props.name;
        this._description = props.description;
        this._fields = props.fields;
        this._createdAt = props.createdAt;
        this._updatedAt = props.updatedAt;
        this._serverApi = props.serverApi;
    }

    get isEditState()
    {
        return this._isEditState;
    }

    set isEditState(value)
    {
        this._isEditState = value;
    }

    async updateIssueInformation(props)
    {
        const result = await this._serverApi.updateIssue({
            name: props.name,
            description: props.description,
        })

        if (result)
        {
            // is fuck was given
        }

        this._name = props.name;
        this.description = props.description;
    }

    get name()
    {
        return this._name;
    }

    get description()
    {
        return this._description;
    }

    get fields()
    {
        return this._fields;
    }

    get createdAt()
    {
        return this._createdAt;
    }

    get updatedAt()
    {
        return this._updatedAt;
    }
}