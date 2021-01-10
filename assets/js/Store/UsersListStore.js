export default class UsersListStore
{
    _serverApi = null;

    _usersList = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async getUsers()
    {
        const response = await this._serverApi.getUsersList();

        if(response)
        {
            this._usersList = response;
            return await response;
        }
    }

    get usersList()
    {
        return this._usersList;
    }
}