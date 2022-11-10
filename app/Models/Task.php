<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;
    // テーブル名の指定 上書き
    protected $table = 'task';
    // 登録する際に設定できる項目(カラム)
    protected $fillable = ['title', 'content', 'person_in_charge'];
    /*********************************************
     * 拡張関数
     *********************************************/
    /**
     * Getter 拡張 (snake_case CamelCase対応)
     * @param string $key 指定取得属性名
     * @return mixed 取得結果
     */
    public function getAttribute($key)
    {
        // 指定 取得属性名存在する場合
        if (array_key_exists($key, $this->relations)) {
            // そのまま返却
            return parent::getAttribute($key);
        // それ以外 CamelCase → snake_case
        } else {
            return parent::getAttribute(Str::snake($key));
        }
    }

    /**
     * Setter 拡張 (snake_case CamelCase対応)
     * @param string $key 指定属性名
     * @param mixed $value 設定値
     * @returns mixed HasAttributes.setAttributeの結果
     */
    public function setAttribute($key, $value)
    {
        // → snake_caseにして設定
        return parent::setAttribute(Str::snake($key), $value);
    }
}
