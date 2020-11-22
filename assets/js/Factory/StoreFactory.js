import CreateIssueStore from "../Store/CreateIssueStore";
import IssueStore from "../Store/IssueStore";
import IssueListStore from "../Store/IssueListStore";

export default class StoreFactory
{
    _serverApi = null;

    constructor(serverApi)
    {
        this._serverApi = serverApi;
    }

    /**
     *
     * @param {String} issueCode
     */
    createIssueStore()
    {
        //const issue = this._serverApi.getIssue(issueCode);

        return  new IssueStore(this._serverApi);
    }

    createCreateIssueStore()
    {
        return new CreateIssueStore(this._serverApi);
    }

    createIssuesListStore()
    {
        return new IssueListStore(this._serverApi);
    }
}