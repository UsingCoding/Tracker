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

let vueRouter = new VueRouter({
    mode: 'history',
    routes:[
        { path:'/login', name: 'login', component: login, meta: { title: 'Login' }  },
        { path:'/issues', name:'issues', component: issues, meta: { title: 'Issues' } },
        { path:'/create-issue', name:'create_issue', component: create_issue, meta: { title: 'New Issue' } },
        { path:'/issue/:code', name:'issue_details', component: issue_details, meta: { title: 'Issue' } },
        { path:'/projects', name:'projects_list', component: projects_list, meta: { title: 'Projects' } },
        { path:'/create-project', name:'create_project', component: create_project, meta: { title: 'New Project' } },
        { path:'/project/:code', name:'project_info', component: project_info, meta: { title: 'Project' } },
        { path: '/project/:code/fields', name: 'project_fields', component: project_fields, meta: { title: 'Project Fields' }},
        { path: '/project/:code/settings', name: 'project_settings', component: project_settings, meta: { title: 'Project Settings' }},
        { path: '/project/:code/team', name: 'project_team', component: project_team, meta: { title: 'Project Team' }},
        { path: '/user/:code', name: 'user_info', component: user_info, meta: { title: 'User Info' }},
        { path: '/add/user', name: 'create_user', component: user_info, meta: { title: 'Create User' }},
        { path: '/users', name: 'users_list', component: users_list, meta: { title: 'Users' }},
        { path: '/404', name: 'access_denied', component: access_denied, meta: { title: 'Get Lost?' } },
        { path: '*', redirect: '/404' }
    ]
});

vueRouter.beforeEach(( to, from, next) => {
    document.title = to.meta.title

    next()
});

export default vueRouter;

// VueRouter.afterEach(( to, from) => {
//     Vue.nextTick(() => {
//         document.title = to.meta.title;
//     });
// });
