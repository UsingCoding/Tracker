import Vue from 'vue';
import VueRouter from 'vue-router';
import App from "./components/App";
import issues from "./pages/IssuesPage";
import login from "./components/Login";
import create_issue from "./pages/CreateIssuePage";
import issue_details from "./pages/IssueDetailsPage";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes:[
        { path:'/', name:'home', component: App },
        { path:'/login', name: 'login', component: login },
        { path:'/issues', name:'issues', component: issues },
        { path:'/create_issue', name:'create_issue', component: create_issue },
        { path:'/issue_details', name:'issue_details', component: issue_details }
    ]
});