// エントリーポイント等の設定
/** import vue */
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import Vuex from 'vuex';
/** import parts */
import HeaderComponent from './components/header/Header.vue';
import TaskListView from './view/TaskList.vue';
import TaskView from './view/Task.vue';
import TaskEditorView from "./view/TaskEditor.vue";
/** import store */
import store from './store';
/** import etc */
import MyAxios from './client/useMyAxios';

require('./bootstrap');

window.Vue = require('vue').default;

// vue プラグイン設定
Vue
    .use(VueRouter) // 画面内で利用するルーター :VueRouterでのルーターを利用
    .use(VueAxios, MyAxios)  // 自作 axios 使えにしてみる
    .use(Vuex) // Vuex 自作
;

const router = new VueRouter({
    mode: 'history',
    routes: [
        // ホーム画面パス
        {
            path: '/',
            name: 'home',
            component: TaskListView
        },
        // タスク一覧画面パス
        {
            path: '/tasks',
            name: 'task.list',
            component: TaskListView
        },
        // タスク登録画面パス
        {
            path: '/tasks/new',
            name: 'task.new',
            component: TaskEditorView, // 編集エディター共通化
        },
        // タスク編集画面パス
        {
            path: '/tasks/:taskId/edit',
            name: 'task.edit',
            component: TaskEditorView, // 編集エディター共通化
            props: true, // パラメーターを 画面表示引数にする設定
        },
        // タスク詳細画面パス
        {
            path: '/tasks/:taskId',
            name: 'task.detail',
            component: TaskView,
            props: true, // パラメーターを 画面表示引数にする設定
        },
    ]
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// <header-component>のようにタグとして使えるように登録
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', HeaderComponent);


// store 定義
const myStore = new Vuex.Store(store);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: myStore,
    router
});
