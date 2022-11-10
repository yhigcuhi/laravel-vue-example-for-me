<?php

namespace App\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

/**
 * タスクリポジトリ
 */
class TaskRepository implements TaskRepositoryInterface
{
    /**
     * 全て取得
     * @return Collection|array 結果一覧
     */
    public function findAll()
    {
        // Task::paginate(limit件数)でやると ?page=xでLaravelが自動的にページャーの処理してくれる(orderby以外)
        return Task::all();
    }

    /**
     * ID検索
     * @param int $id 検索値
     * @return Task|null 検索結果
     */
    public function findById(int $id): ?Task
    {
        return Task::where('id', $id)->first();
    }

    /**
     * 新規登録実行
     * @param Task $input 新規登録値
     * @return Task 登録結果
     */
    public function create(Task $input): Task
    {
        // 新規登録実行
        return Task::create($input->toArray());
    }


    /**
     * 更新実行
     * @param int $id 検索ID
     * @param Task $input 更新値
     * @return Task|null 更新結果
     */
    public function update(int $id, Task $input): ?Task
    {
        // 更新対象検索
        $value = $this->findById($id);
        // 存在しない → null
        if (empty($value)) return null;
        // 存在 更新
        $value->update($input->toArray());
        // 更新結果
        return $value;
    }

    /**
     * 指定キー削除
     * @param int $id 指定キー
     * @return bool|null 削除結果
     */
    public function removeById(int $id): ?bool
    {
        // 削除対象検索
        $value = $this->findById($id);
        // 削除実行
        return empty($value) ? false : $value->delete();
    }
}
?>
