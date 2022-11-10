<?php

namespace App\Exceptions;

class TaskNotFoundException extends MyHttpException
{
    // 取り扱うステータスコード
    const STATUS_CODE = 404;
    /**
     * constructor.
     * @param string $message 簡易エラーメッセージ
     */
    public function __construct(string $message = 'task is not found')
    {
        // super コンストラクタ
        parent::__construct($message, self::STATUS_CODE);
    }
}
