import CreateIssueStore from "../Store/CreateIssueStore";
import IssueStore from "../Store/IssueStore";
import IssueListStore from "../Store/IssueListStore";
import CreateProjectStore from "../Store/CreateProjectStore";
import ProjectStore from "../Store/ProjectStore";
import UserStore from "../Store/UserStore";
import ProjectsListStore from "../Store/ProjectsListStore";
import FieldStore from "../Store/FieldStore";
import CreateFieldStore from "../Store/CreateFieldStore";
import FieldsListStore from "../Store/FieldsListStore";
import MemberStore from "../Store/MemberStore";
import UsersListStore from "../Store/UsersListStore";
import MembersListStore from "../Store/MembersListStore";
import CreateCommentStore from "../Store/CreateCommentStore";
import CommentStore from "../Store/CommentStore";
import CommentsListStore from "../Store/CommentsListStore";

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

    createProjectsListStore()
    {
        return new ProjectsListStore(this._serverApi);
    }

    createCreateProjectStore()
    {
        return new CreateProjectStore(this._serverApi);
    }

    createProjectStore()
    {   
        return new ProjectStore(this._serverApi);
    }

    createUserStore()
    {
        return new UserStore(this._serverApi);
    }

    createFieldStore()
    {
        return new FieldStore(this._serverApi);
    }

    createCreateFieldStore()
    {
        return new CreateFieldStore(this._serverApi);
    }

    createFieldsListStore()
    {
        return new FieldsListStore(this._serverApi);
    }

    createMemberStore()
    {
        return new MemberStore(this._serverApi);
    }

    createUsersListStore()
    {
        return new UsersListStore(this._serverApi);
    }

    createMembersListStore()
    {
        return new MembersListStore(this._serverApi);
    }

    createCreateCommentStore()
    {
        return new CreateCommentStore(this._serverApi);
    }

    createCommentStore()
    {
        return new CommentStore(this._serverApi);
    }

    createCommentsListStore()
    {
        return new CommentsListStore(this._serverApi);
    }
}