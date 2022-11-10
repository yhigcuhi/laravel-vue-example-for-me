<!-- タスク詳細 -->
<script>
    // スクリプト定義
    export default {
        name:'Task',
        props: {
            // 表示するタスクID
            taskId: {
                required: true
            }
        },
        // 画面状態変更ハンドラー (返却値あり)
        computed: {
            // 画面表示値 = vuexから 取得 (TODO: 問題点は F5した時 tasks消えるので vuex-persistedstate導入)
            task() { return this.$store.getters.findTaskById(this.taskId); }
        }
    }
</script>
<!-- タスク詳細 描画 -->
<template>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="mb-3 border-bottom">
                <label for="id" class="form-label fw-bold">ID:</label>
                <div id="id" class="p-2">{{ taskId }}</div>
            </div>
            <div class="mb-3 border-bottom">
                <label for="title" class="form-label fw-bold">タスク タイトル:</label>
                <div id="title" class="p-2">{{ task.title }}</div>
            </div>
            <div class="mb-3 border-bottom">
                <label for="content" class="form-label fw-bold">内容:</label>
                <div id="content" class="p-2">{{ task.content }}</div>
            </div>
            <div class="mb-3 border-bottom">
                <label for="person-in-charge" class="form-label fw-bold">担当者:</label>
                <div id="person-in-charge" class="p-2">{{ task.person_in_charge }}</div>
            </div>
        </div>
    </div>
</template>
