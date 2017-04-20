<?php
/**
 * Created by PhpStorm.
 * User: denny
 * Date: 16/9/9
 * Time: 下午2:30
 * 拼接地址并采用POST或GET提交
 */

namespace Home\Api;


class Curl
{


    /**
     * post提交数据
     * @param $url
     * @param $post_data
     * @return mixed
     */
    public static function curlPost($url, $post_data)
    {
        header("Content-Type:text/html;charset=UTF-8");
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        set_time_limit(120);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;


    }

    /**
     * 上传文件
     * @param $url
     * @param $path
     * @return mixed
     */
    public static  function upload_file($url, $path)
    {   $path=realpath($path);

        $data = array('pic' => new \CURLFile($path));
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);


        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_getinfo($ch);
        $return_data = curl_exec($ch);
        curl_close($ch);
        return $return_data;
    }

    /**
     * get提交数据
     * @param $url
     * @return mixed
     */
    public static function curlGet($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURL_SSLVERSION_SSL, 2);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $data = curl_exec($ch);

        return $data;
    }

    /**
     * json转数组
     * @param $json
     * @return array
     */
    public static function jsonToArray($json)
    {

        $data=json_decode($json,true);

        return $data;
    }

}