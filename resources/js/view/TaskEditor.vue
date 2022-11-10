<!-- タスク編集画面 -->
<script>
    // デフォルト値の定義
    const DEFAULT_VALUE = {
        title: '',
        content: '',
        person_in_charge: ''
    };
    const DEFAULT_ERRORS = {
        title: '',
        person_in_charge: '',
    };

    // タスク編集 スクリプト定義
    export default {
        name:'TaskEditor',
        // 画面表示引数
        props: {
            // 編集タスクID
            taskId: {
                required: false // 任意 = 指定なし ? 登録 : 編集
            }
        },
        // 内部利用データ
        data() {
            return {
                // 編集タスクID
                // taskId: '',
                defaultTask: _.cloneDeep(DEFAULT_VALUE),
                // 表示するタスク
                task: _.cloneDeep(DEFAULT_VALUE),
                // 編集モード
                isEdit: false,
                // エラー {[項目名 as string]: エラーメッセージ as string}
                errors: {},
                // 送信中 (true:送信中 / false: それ以外)
                isSubmitting: false,
            }
        },
        // 内部利用関数一覧
        methods: {
            /**
             * 画面表示タスク 最新化
             */
            fetchTask() {
                // クリア → デフォルト値
                this.clear(DEFAULT_VALUE);
                // 前提条件
                if (!this.taskId) return;

                // 対象取得
                this.axios.get(`/tasks/${this.taskId}`)
                    .then((res) => {
                        // 画面表示値反映
                        this.clear(res.data); // レスポンスの値で再設定
                    });
            },
            /**
             * 画面表示値クリア 引数: 設定するデフォルト値
             * @param {object|undefined} defaultValue 設定するデフォルト値
             */
            clear(defaultValue = {}) {
                // 指定クリア値存在 → デフォルト値 クリア
                if (!_.isEmpty(defaultValue))  this.defaultTask = _.cloneDeep(defaultValue);
                // フォーム タスク初期化
                this.initializeValue(this.defaultTask);
                // エラー情報クリア
                this.errors = _.cloneDeep(DEFAULT_ERRORS);
            },
            /**
             * フォームの値初期化
             * @param {object} value 初期化する値
             */
            initializeValue(value) {
                // タスク初期化
                this.task = _.cloneDeep(value);
            },
            /**
             * 登録・編集 submit
             */
            onSubmit() {
                // 多重送信防止
                if (this.isSubmitting) return; // 何もしない
                // エラー情報存在
                if (!this.checkForm()) {
                    // 送信可能
                    this.isSubmitting = false;
                    // 後続しない
                    return;
                }

                // 送信中
                this.isSubmitting = true;
                // タスクIDあり かつ編集モード(念の為) → 更新通信
                if (this.taskId && this.isEdit) {
                    // 更新通信
                    this.axios.put(`/tasks/${this.taskId}`, this.task)
                        .then((res) => { // 成功時
                            // 送信完了
                            this.isSubmitting = false;
                            // タスク詳細へ
                            this.$router.push({name: 'task.detail', params: {taskId: this.taskId}});
                        });
                // それ以外 → 登録通信
                } else {
                    this.axios.post('/tasks', this.task)
                        .then((res) => { // 成功時
                            // 送信完了
                            this.isSubmitting = false;
                            // 一覧へ
                            this.$router.push({name: 'task.list'});
                        });
                }
            },
            /**
             * バリデーションチェック実行
             * @returns {boolean} true: 正常/ false: それ以外
             */
            checkForm() {
                // エラー情報初期化 (クリア)
                this.errors = _.cloneDeep(DEFAULT_ERRORS);
                // 各フォーム チェック
                this.checkFormTitle();
                this.checkFormPersonInCharge();
                // 結果 エラー情報
                return this.validation
            },
            // 各フォーム チェック
            checkFormTitle() { this.errors.title = this.validationTitle ? '' : 'タイトルの指定は必須です' },
            checkFormPersonInCharge() { this.errors.person_in_charge = this.validationPersonInCharge ? '' : '担当者の指定は必須です' },
            // 送信可能判定
            canSubmit() {
              return _.every([this.isSubmitting, this.validation]);
            },
            // クリア押下ハンドラー
            onClickClear() {
                this.clear();
                // バブリング等させない
                return false;
            },
        },
        // 画面生成時
        created() {
            // 対象取得
            this.fetchTask();
        },
        // 値変更時の監視 → 値返却系
        computed: {
            // 現場のバリデーション結果を保持
            validation: function() { return _.every([this.validationTitle, this.validationPersonInCharge]); },
            // タイトル変更時にバリデーションチェック結果を保持
            validationTitle: function() { return !_.isEmpty(this.task.title); },
            // 担当者変更時にバリデーションチェック結果を保持
            validationPersonInCharge: function() { return !_.isEmpty(this.task.person_in_charge); },
        },
        // 値変更時の監視 → void
        watch: {
            // 画面引数 taskId(ルーターパラメーターになるやつ) 変更監視
            taskId: {
                /**
                 * 値変更ハンドリング
                 * @param {string | undefined} val 変更値
                 */
                handler: function (val) {
                    // タスクID 指定なし → 登録モード
                    if (!val) {
                        this.isEdit = false;
                        this.clear(DEFAULT_VALUE);
                    }
                    // それ以外 → 編集モード
                    else {
                        this.isEdit = true;
                        // 最新化
                        this.fetchTask();
                    }
                },
                // 初回表示の時も実行
                immediate: true
            },
            // フォームバリデーションチェック (computed だと初回表示も動くのでこちらで)
            // タイトルチェック
            'task.title': function () { this.checkFormTitle(); },
            // 担当者チェック
            'task.person_in_charge': function () { this.checkFormPersonInCharge(); },
        },
        // 画面消える前
        beforeDestroy() { this.isSubmitting = false; },
    }
</script>

<!-- タスク登録画面 描画 -->
<template>
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- タスク登録 フォーム -->
            <form v-on:submit.prevent="onSubmit">
                <!-- タイトル -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">タスク タイトル 【必須】:</label>
                    <input id="title" type="text" aria-describedby="titleHelp" class="form-control" v-model="task.title" />
                    <div id="titleHelp" class="form-text">※タスクのタイトルは必須になります.</div>
                    <span v-show="!validationTitle" class="text-danger">{{ errors.title }}</span>
                </div>
                <!-- タイトル -->
                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">内容:</label>
                    <input id="content" type="text" class="form-control" v-model="task.content" />
                </div>
                <!-- 担当者 -->
                <div class="mb-3">
                    <label for="person-in-charge" class="form-label fw-bold">担当者 【必須】:</label>
                    <input id="person-in-charge" type="text" class="form-control" v-model="task.person_in_charge" />
                    <span class="text-danger">{{ errors.person_in_charge }}</span>
                </div>
                <!-- 登録編集ボタン -->
                <button type="submit" class="btn btn-primary" v-if="!isEdit" v-bind:disabled="canSubmit() ? true : false">追加</button>
                <button type="submit" class="btn btn-primary" v-else v-bind:disabled="canSubmit() ? true : false">更新</button>
                <!-- クリア(独自処理) -->
                <button class="btn btn-secondary" @click.prevent="onClickClear">クリア</button>
            </form>
        </div>
    </div>
</template>
