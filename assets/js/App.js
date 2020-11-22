import styles from './styles.css'

import Vue from 'vue';

import Routes from './Router';

import App from './components/App';

new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
});