<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;

/**
 * Http Errorを持ったカスタム例外クラス
 */
class MyHttpException extends RuntimeException implements Responsable
{

    /**
     * @var string メッセージ
     */
    protected $message;

    /**
     * @var int レスポンスコード
     */
    protected $statusCode;

    /**
     * @var string|null エラーコード
     */
    protected $errorCode;

    /**
     * 初期エラーコード一覧
     * ステータスコードに紐付いた基本的なエラーコードで、アプリケーション固有のエラーコードは定義しない
     *
     * @var array
     */
    protected $defaultErrorCodes = [
        400 => 'bad_request',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'not_found',
        405 => 'method_not_allowed',
        422 => 'validation_error',
        500 => 'internal_server_error',
    ];

    /**
     * constructor.
     *
     * @param string $message 簡易エラーメッセージ
     * @param int $statusCode ステータスコード
     */
    public function __construct(string $message = '', int $statusCode = 500)
    {
        // メッセージ指定なし → デフォルト エラーコードの名前設定
        $this->message = empty($message) ? $this->defaultErrorCodes[$statusCode] : $message;
        $this->statusCode = $statusCode;
    }


    /**
     * @param string $message
     */
    public function setErrorMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $errorCode
     */
    public function setErrorCode(string $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return null|string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * 拡張 Httpレスポンスボディへ (JSONでもつ)
     * @param $request
     * @return JsonResponse
     */
    public function toResponse($request)
    {
        return new JsonResponse(
            $this->getBasicResponse(),
            $this->getStatusCode()
        );
    }

    protected function getBasicResponse()
    {
        return [
            'message' => $this->getErrorMessage(),
            'code' => $this->getErrorCode() ?? $this->getDefaultErrorCode(),
        ];
    }

    protected function getDefaultErrorCode(): string
    {
        return $this->defaultErrorCodes[$this->getStatusCode()];
    }
}
