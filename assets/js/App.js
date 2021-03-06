import styles from './styles.css'

import Vue from 'vue';

import Routes from './Router';

import App from './components/App';

import ServerApi from "./Api/ServerApi";
import StoreFactory from "./Factory/StoreFactory";

const serverApi = new ServerApi();
const factory = new StoreFactory(serverApi);

import ScrollLoader from "vue-scroll-loader";

Vue.use(ScrollLoader);

new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
});