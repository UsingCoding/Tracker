import Vue from 'vue';
import VueRouter from 'vue-router';
import issues from "./pages/IssuesPage";
import login from "./components/Login";
import create_issue from "./pages/CreateIssuePage";
import issue_details from "./pages/IssueDetailsPage";
import projects_list from "./pages/ProjectsListPage";
import create_project from "./pages/CreateProjectPage";
import project_info from "./pages/ProjectInfoPage";
import project_fields from "./pages/ProjectFieldsPage";
import project_settings from "./pages/ProjectSettingsPage";
import project_team from "./pages/ProjectTeamPage";
import user_info from "./pages/UserPage";
import users_list from "./pages/UsersListPage";
import access_denied from "./pages/AccessDeniedPage";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes:[
        { path:'/login', name: 'login', component: login },
        { path:'/issues', name:'issues', component: issues },
        { path:'/create-issue', name:'create_issue', component: create_issue },
        { path:'/issue/:code', name:'issue_details', component: issue_details },
        { path:'/projects', name:'projects_list', component: projects_list },
        { path:'/create-project', name:'create_project', component: create_project },
        { path:'/project/:code', name:'project_info', component: project_info },
        { path: '/project/:code/fields', name: 'project_fields', component: project_fields},
        { path: '/project/:code/settings', name: 'project_settings', component: project_settings},
        { path: '/project/:code/team', name: 'project_team', component: project_team},
        { path: '/user/:code', name: 'user_info', component: user_info},
        { path: '/add/user', name: 'create_user', component: user_info},
        { path: '/users', name: 'users_list', component: users_list},
        { path: '/404', name: 'access_denied', component: access_denied },
        { path: '*', redirect: '/404' }
    ]
});