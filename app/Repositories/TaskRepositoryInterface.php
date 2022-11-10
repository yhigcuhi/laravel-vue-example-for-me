<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * 一覧検索
     * @return Collection|array 検索結果
     */
    public function findAll();
    /**
     * ID検索
     * @param int $id 検索ID
     * @return Task|null 検索結果
     */
    public function findById(int $id): ?Task;

    /**
     * 新規登録実行
     * @param Task $input 新規登録値
     * @return Task 登録結果
     */
    public function create(Task $input): Task;

    /**
     * 更新実行
     * @param int $id 検索ID
     * @param Task $input 更新値
     * @return Task|null 更新結果
     */
    public function update(int $id, Task $input): ?Task;

    /**
     * 指定キーの削除
     * @param int $id 削除キー
     * @return bool|null 削除結果
     */
    public function removeById(int $id): ?bool;
}
