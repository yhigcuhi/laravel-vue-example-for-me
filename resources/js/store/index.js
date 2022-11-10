/*********************************************
 * このプロジェクト Vuex 管理
 *********************************************/
/** import modules */
import tasks from './tasks';
import createPersistedState from 'vuex-persistedstate';

/* export */
export default {
    strict: process.env.NODE_ENV !== 'production',
    // 拡張プラグイン
    plugins: [createPersistedState({
        storage: window.sessionStorage, // キャッシュ保存先
        key: 'my-vuex-sample', // キャッシュ保存キー
        paths: [ // キャッシュしておくもの一覧
            'tasks'
        ],
    })],
    modules: {
        tasks // タスク一覧管理
    },
    state: {
    },
    getters: {
    },
    mutations: {
    },
    actions: {
    },
};
