<?php
/**
 * Created by PhpStorm.
 * User: denny
 * Date: 16/9/29
 * Time: 下午3:20
 */

namespace Home\Api;


class Json
{

    static function encode($data)
    {

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


}