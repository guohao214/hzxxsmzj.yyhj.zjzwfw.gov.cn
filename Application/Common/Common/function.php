<?php
/**
 * Created by PhpStorm.
 * User: denny
 * Date: 11/22/16
 * Time: 4:53 PM
 */

/**
 * 调试打印信息
 * @param $data
 * @param bool|false $true
 */
function p($data,$true=false){
    echo '<pre>';
    var_dump($data);
    echo '<pre>';
    if($true)
        die;
}


/**
 * 可逆加密函数，基于base64加密
 * @param $string 需加密字符串
 * @param string $operation 解密/加密
 * @param string $key 秘钥
 * @param int $expiry
 * @return string 返回加密或解密后的字符串
 */
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;	// 随机密钥长度 取值 0-32;
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
    $key = md5($key ? $key : AUTH_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}


//数据格式化
function sortData($default_arr,$pid){
    $second=array();

    $alllast=array();

    foreach($default_arr['items'] as $k=>$v){
        if($v['parentId']==$pid){
            array_push($second,$v);
            $alllast['sc_'.$v['id']]=array();
            foreach($default_arr['items'] as $k1=>$v1){
                if($v['id']==$v1['parentId']){
                    array_push($alllast['sc_'.$v['id']],$v1);
                }
            }
        }
    }
    return array('second'=>$second,'alllast'=>$alllast);
}