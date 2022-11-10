<?php

namespace App\Http\Controllers;

use App\Exceptions\TaskNotFoundException;
use App\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

/**
 * /tasks REST コントローラー
 */
class TaskController extends Controller
{
    /*********************************************
     * フィールド
     *********************************************/
    /* 利用サービス */
    private TaskService $service;

    /*********************************************
     * コンストラクタ
     * @param TaskService $service 注入するサービス
     *********************************************/
    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }
    /**
     * タスク一覧 取得
     * @return JsonResponse タスク一覧
     */
    public function findAll(): JsonResponse
    {
        return response()->json($this->service->findAll());
    }

    /**
     * ID検索
     * @param int $id
     * @return JsonResponse
     */
    public function findById(int $id): JsonResponse
    {
        return response()->json($this->service->findById($id));
    }

    /**
     * 新規追加
     * @param Request $request 追加リクエスト
     * @return JsonResponse
     */
    public function post(Request $request): JsonResponse
    {
        // TODO: トランザクションの監視 ASP、リクエスト JSONの デシリアラズ to Type
        // request → Task 追加するタスク
        $input = new Task($request->all());
        // 入力補完 cammel case
        if (empty($input->getAttribute('person_in_charge'))) $input->setAttribute('person_in_charge', $request->get('personInCharge'));

        // TODO: サービスとサービスをまたがる場合の トランザクション監視
        // 新規追加実行
        return response()->json($this->service->create($input));
    }

    /**
     * 更新
     * @param Request $request 更新リクエスト
     * @param int $id 更新対象キー
     * @return JsonResponse
     */
    public function put(Request $request, int $id): JsonResponse
    {
        // 前提条件
        if (empty($id)) throw new TaskNotFoundException();
        // TODO: トランザクションの監視 ASP、リクエスト JSONの デシリアラズ to Type
        // request → Task 更新するタスク
        $input = new Task($request->all());
        // 入力補完 cammel case
        if (empty($input->getAttribute('person_in_charge'))) $input->setAttribute('person_in_charge', $request->get('personInCharge'));

        // TODO: サービスとサービスをまたがる場合の トランザクション監視
        // 指定あり → 更新実行
        return response()->json($this->service->update($id, $input));
    }

    /**
     * 削除
     * @param int $id 削除キー
     * @return JsonResponse 結果
     */
    public function delete(int $id): JsonResponse
    {
        // 前提条件
        if (empty($id)) return response()->json(null); // 空
        // 指定あり → 削除実行
        return response()->json($this->service->remove($id));
    }
}
