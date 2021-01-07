import Strings from "../Utils/Strings"

export default class IssueStore
{
    _fieldsNamesMap = {
        project_name: 'Project'
    }

    _serverApi = null;

    _name = null;
    _description = null;
    _fields = null;
    _createdAt = null;
    _updatedAt = null;
    _comments = null;

    _isEditState = false;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    getFieldName(fieldCode)
    {
        if(this._fieldsNamesMap.hasOwnProperty(fieldCode))
            return this._fieldsNamesMap[fieldCode];
            
        return Strings.capitalizeFirstLetter(fieldCode);   
    }

    get isEditState()
    {
        return this._isEditState;
    }

    set isEditState(value)
    {
        this._isEditState = value;
    }

    async updateIssue(props)
    {
        const result = await this._serverApi.updateIssue(props)
        if (result)
        {
            this._name = props.name;
            this.description = props.description;
            return result;            
        }

    }

    async getIssueInformation(issue_id)
    {
        const response = await this._serverApi.getIssue(issue_id);
        if(response)
        {
            this._name = response.name;
            this._description = response.description;
            this._createdAt = response.created_at;
            return response;
        }
    }

    async deleteIssue(issue_id)
    {
        const response = await this._serverApi.deleteIssue(issue_id);
        if(response)
        {
            return response;
        }
    }

    get name()
    {
        return this._name;
    }

    get description()
    {
        return this._description;
    }

    set description(value)
    {
        this._description = value;
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