<!-- タスク一覧 -->
<script>
    import {mapActions} from 'vuex';

    // タスク一覧定義
    export default {
        name:'TaskList',
        methods: {
            // vuex 関数インジェクション
            ...mapActions(['fetchTasks', 'removeTaskById']),
        },
        // 画面生成時 ハンドラー
        created() {
            // vuex fetchTasks dispath
            this.fetchTasks().then((res) => {
                console.log('これは無理かなw', res)
            });
        },
        // 状態変更ハンドラー
        computed: {
            // タスク一覧
            tasks() { return this.$store.getters.getTasks(); }
        },

    }
</script>

<!-- タスク一覧 デザイン -->
<template>
    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Content</th>
                <th scope="col">Person In Charge</th>
                <th scope="col">At</th>
                <th scope="col">Show</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <!-- 各タスク 行描画 -->
            <tr v-for="task in tasks" :key="task.id">
                <th scope="row">{{ task.id }}</th>
                <td>{{ task.title }}</td>
                <td>{{ task.content }}</td>
                <td>{{ task.person_in_charge }}</td>
                <td>{{ task.updated_at }}</td>
                <td>
                    <router-link v-bind:to="{name: 'task.detail', params: {taskId: task.id}}">
                        <button class="btn btn-primary">Show</button>
                    </router-link>
                </td>
                <td>
                    <router-link v-bind:to="{name: 'task.edit', params: {taskId: task.id}}">
                        <button class="btn btn-success">Edit</button>
                    </router-link>
                </td>
                <td>
                    <button class="btn btn-danger" @click="removeTaskById({id: task.id})">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
