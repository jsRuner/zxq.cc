<?php
/**
 * Created by PhpStorm.
 * User: andery
 * Date: 14-3-28
 * Time: 下午6:14
 */


/**
 * 获取 IP  地理位置
* 淘宝IP接口
* @Return: array
*/
function getCity($ip)
{
    $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    #限制了每秒请求不超过10次。这里需要处理。2015年9月25日8:55:14 吴文付
    #先判断code是否存在，再去比较是否为1
    $ip=json_decode(@file_get_contents($url));
    if((string)$ip->code=='1'){
//    if(!isset($ip) || !isset($ip->code) ||(string)$ip->code=='1'){
       return false;
     }
     $data = (array)$ip->data;
    return $data;   
}

/**
* 随机字符串生成
 * @param  integer $len    [长度]
 * @param  string  $format [生成类型]
 * @return [type]          [description]
*/
function rand_str_sn($len = 10, $format = 'NUMBER') {
    switch (strtoupper($format)) {
        case 'ALL' :
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
        case 'CHAR' :
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
        case 'NUMBER' :
            $chars = '0123456789';
            break;
        default :
            $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
    }
    $string = "";
    while ( strlen ( $string ) < $len )
        $string .= substr ( $chars, (mt_rand () % strlen ( $chars )), 1 );
    return $string;
}


function arrange_html_img($matches)
{
    if (false === strpos($matches[2], 'http://')) {
        //return '<img '.$matches[1].'src="'.base_url('data/attachment/'.$matches[2]).'" '.$matches[3].'/>';
        return '<img '.$matches[1].'src="'.image_url($matches[2]).'" '.$matches[3].'/>';
    } else {
        return $matches[0];
    }
}



/**
 * 邮箱验证 通过返回true 不通过返回false
 * @param $email
 * @return bool
 */
function valid_email($email){
    if(!$email)
    {
        return false;
    }
    $result = preg_grep('/^([a-zA-Z0-9]|[._])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/',array($email));
    if($result)
    {
        return true;
    }else{
        return false;
    }
}

/**
 * 手机验证  通过返回true 不通过返回false
 * @param $mobile
 * @return bool
 */
function valid_mobile($mobile)
{
    if(!$mobile)
    {
        return false;
    }
    $result = preg_grep('/^((1[35847]\d{9}))$|^(09)\d{8}$/',array($mobile));
    if($result)
    {
        return true;
    }else{
        return false;
    }
}

function valid_QQ($qq)
{
    if(!$qq)
    {
        return false;
    }
    $result = preg_grep('/^\d{5,10}$/',array($qq));
    if($result)
    {
        return true;
    }else{
        return false;
    }
}

/*
 * 本周开始时间戳
 */
function current_week_begin()
{
    $w = date('w') == 0 ? 7 : date('w');
    return mktime(0,0,0,date('m'),date('j')-$w+1,date('Y'));
}

/*
 * 本月开始时间戳
 */
function current_month_begin()
{
    return mktime(0,0,0,date("m", time()),1,date("Y", time()));
}

function month_begin($time)
{
    return mktime(0,0,0,date("m", $time),1,date("Y", $time));
}

function week_begin($time)
{
    $w = date('w', $time) == 0 ? 7 : date('w', $time);
    return mktime(0,0,0,date('m', $time),date('j', $time)-$w+1,date('Y', $time));
}

/**
        $params = array(
            "logis_code" => 'shentong',
            "logis_no" => 968101798017,
            "province" => '浙江省',
            "city" => '杭州市'
        );
        poll_logistic($params);
 */
function poll_logistic($params=array())
{
    $CI = & get_instance();
    $params['source_ip'] = $CI->input->ip_address();
    $params['source_app'] = 0;//表示来源商城
    $url = LOGISTICS_SERVER.'api/kuaidi100/poll';
    $CI->load->library('Curl');
    $CI->curl->create($url);
    $CI->curl->post($params);
    $response = $CI->curl->execute();
    return $response;
    //$CI->curl->debug();
}

/**
 * 2015年6月17日
 * 吴文付
 * 格式化输出数组
 * @param string $value [description]
 */
function  wwf_dump($vars, $label = '', $return = false) {
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}

/**
 * 提取字符串中的数字
 * @param $str
 * @return mixed
 */
function number($str)
{
    return preg_replace('/\D/s', '', $str);
}


/**
 * 字符串截取，支持中文和其他编码
 * static
 * access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * return string
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

//返回赔率趋势字符串.如果为默认值 10000.则没有提示。
function retruntrendstr($float){
    if ($float == 10000){
        return "";
    }

    if ($float > 0){
        return "上升".$float;
    }else if($float == 0){
        return "持平";
    }else{
        return "下降".abs($float);
    }
}