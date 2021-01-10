export default class UserStore
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    async createUser(props)
    {
        const response = await this._serverApi.createUser(props);

        if(response)
            return await response;
    }

    async getUserInfo(user_id)
    {
        const response = await this._serverApi.getUser(user_id);

        if(response)
            return await response;
    }

    async editUserInfo(props)
    {
        const response = await this._serverApi.editUser(props);

        if(response)
            return await response;
    }

    async deleteUser(user_id)
    {
        const response = await this._serverApi.deleteUser(user_id);

        if(response)
            return await response;   
    }
}