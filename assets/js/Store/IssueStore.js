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
        // const result = await this._serverApi.updateIssue({
        //     issue_id: props.issue_id,
        //     name: props.name,
        //     description: props.description,
        //     fields: { 
        //         user_id: props.user_id,
        //         project_id: props.project_id
        //     }
        // })
        const result = await this._serverApi.updateIssue(props)
        if (result)
        {
            // is fuck was given
        }

        this._name = props.name;
        this.description = props.description;
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