/*********************************************
 * Tasks Vuex 管理
 *********************************************/
/** import */
import MyAxios from '../client/useMyAxios';

/*********************************************
 * Tasks store 定義
 *********************************************/
// 管理物
const state = {
    tasks: [],
}
// getter
const getters = {
    // 一覧取得
    getTasks: state => () => state.tasks,
    // 指定IDのタスク取得
    findTaskById: state => (id) => state.tasks.find(task => task.id === id),

};
// アクション一覧
const actions = {
    // 最新化
    async fetchTasks({commit}) {
        // タスク一覧 GET
        const response = await MyAxios.get('/tasks');
        // タスク一覧最新化 mutation実行
        commit('setTasks', response.data);
    },
    // タスク削除 Id
    async removeTaskById({commit}, {id}) {
        // タスク削除 実行
        MyAxios.delete(`/tasks/${id}`).then(() => commit('removeTaskById', id));
    },
};
// reducer的なやつ
const mutations = {
    // タスク設定
    setTasks: (state, tasks) => {state.tasks = tasks},
    // タスク削除
    removeTaskById: (state, id) => { state.tasks = state.tasks.filter(task => task.id !== id) },
};

/* export */
export default {
    state,
    getters,
    actions,
    mutations,
}
