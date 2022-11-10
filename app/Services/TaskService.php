<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * タスクサービス
 */
class TaskService
{
    /*********************************************
     * フィールド
     *********************************************/
    /* 利用リポジトリ */
    private TaskRepositoryInterface $repository;

    /*********************************************
     * コンストラクタ
     * @param TaskRepositoryInterface $repository 注入するリポジトリ実装
     *********************************************/
    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    /*********************************************
     * 外部参照可能関数
     *********************************************/
    /**
     * @return Collection|array タスク一覧取得
     */
    public function findAll()
    {
        // 全て取得
        return $this->repository->findAll();
    }

    /**
     * ID 検索
     * @param int $id 検索値
     * @return Task|null 検索結果
     */
    public function findById(int $id): ?Task
    {
        // 指定ID検索
        return $this->repository->findById($id);
    }

    /**
     * 新規登録
     * @param Task $input 新規登録値
     * @return Task 登録結果
     */
    public function create(Task $input): Task
    {
        // トランザクション管理し実行
        return DB::transaction(function () use ($input) {
            // 新規登録実行
            return $this->repository->create($input);
        });
    }

    /**
     * 更新実行
     * @param int $id 更新対象のキー
     * @param Task $input 更新値
     * @return Task|null 更新結果 (キーなし:null)
     */
    public function update(int $id, Task $input): ?Task
    {
        // IDない場合
        if (empty($this->findById($id))) throw new TaskNotFoundException();

        // トランザクション管理し実行
        return DB::transaction(function () use ($id, $input) {
            // 更新実行
            return $this->repository->update($id, $input);
        });
    }

    /**
     * 指定IDのデータ削除
     * @param int $id 削除対象キー
     * @return bool 削除結果(true:正常/ false:それ以外)
     */
    public function remove(int $id): bool
    {
        // 前提条件 タスクなし
        if (empty($this->findById($id))) throw new TaskNotFoundException();

        // トランザクション管理し実行
        return DB::transaction(function () use ($id) {
            // 削除実行
            return $this->repository->removeById($id);
        });
    }
}
