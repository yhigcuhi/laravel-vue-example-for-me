/*********************************************
 * 拡張 axios設定
 *********************************************/
/** import */
import Vue from 'vue';
import Axios from 'axios'

/*********************************************
 * 内部参照可能定数
 *********************************************/
// 接続先
const BASE_URL = __DEV__ ? 'http://localhost:8080/webapi' : 'http://localhost:8080/webapi';

// 共通設定するクライアント
const myAxios = Axios.create({
    baseURL: BASE_URL, // 接続先

});

// 共通リクエストハンドラー設定
myAxios.interceptors.request.use(
    // 通常リクエストハンドラー
    (config) => {
        console.log('共通化？')
        // config.headers = {
        //     // TODO: 例えば... JWT埋め込むならとか
        //     // 'Authorization' :'Bearer ' +　localStorage.getItem('myToken')
        // }
        return config;
    },
);

// 共通レスポンスハンドラー設定
myAxios.interceptors.response.use(
    // 通信成功時の共通ハンドラー
    (response) => {
        // TODO: 例えば認証成功のキーを設定するとか
        return response;
    },
    // 通信失敗時の共通ハンドラー
    (error) => {
        // エラーコード別ハンドラー
        switch (error.response.status) {
            // 特定のエラーハンドリング
            case 401: // 認証エラー
            case 404: // TODO:お試し
            case 500: // システムエラー
                Vue.toasted.clear();
                Vue.toasted.error(error.response.data.message);
                break;
            // それ以外
            default:
                break;
        }
        // 失敗処理へ
        return Promise.reject(error);
    }
);
// export 共通クライアント
export default myAxios;
