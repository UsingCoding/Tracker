import Vue from 'vue';
import VueRouter from 'vue-router';
import App from "./components/App";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes:[
        { path:'/', name:'home', component: App }
    ]
});