<?php

/**
 * 使用curl获取远程数据
 *
 * @param string $url url连接
 * @return string      获取到的数据
 */
function curl_get_contents($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);                                    //设置访问的url地址
    curl_setopt($ch, CURLOPT_HEADER, 1);                               //是否显示头部信息
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);                            //设置超时
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);      //用户访问代理 User-Agent
    curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);               //设置 referer
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);                      //跟踪301
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);                    //返回结果
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}


/**
 * 传入时间戳,计算距离现在的时间
 *
 * @param number $time 时间戳
 * @return string     返回多少以前
 */
function word_time($time)
{
    $time = (int)substr($time, 0, 10);
    $int = time() - $time;
    $str = '';
    if ($int <= 2) {
        $str = sprintf('刚刚', $int);
    } elseif ($int < 60) {
        $str = sprintf('%d秒前', $int);
    } elseif ($int < 3600) {
        $str = sprintf('%d分钟前', floor($int / 60));
    } elseif ($int < 86400) {
        $str = sprintf('%d小时前', floor($int / 3600));
    } elseif ($int < 1728000) {
        $str = sprintf('%d天前', floor($int / 86400));
    } else {
        $str = date('Y-m-d H:i:s', $time);
    }
    return $str;
}


// 百度搜索平台
function baiduSite($aid)
{
    $urls[0] = '';
    $api = env('BAIDU_SITE_URL');
    $ch = curl_init();
    $options = [
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    ];
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    $msg = json_decode($result, true);

    if (isset($msg['code']) && $msg['code'] == 500) {
        curl_exec($ch);
    }
    curl_close($ch);
}


/**
 * 方糖推送
 *
 * @param $text
 * @param string $desp
 * @return false|string
 */
function ftSend($text, $desp = '')
{
    $key = env('FANGTANG_KEY');
    $postdata = http_build_query([
        'text' => $text,
        'desp' => $desp
    ]);

    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-type: application/x-www-form-urlencoded',
            'content' => $postdata
        ]
    ];
    $context = stream_context_create($opts);
    return file_get_contents('https://sc.ftqq.com/' . $key . '.send', false, $context);
}


/**
 * 添加水印
 *
 * @param $filePath
 * @return bool
 */
function addWater($filePath)
{
    /*打开图片*/
    //1、配置图片路径
    $src = $filePath;
    //2、获取图片信息
    $info = getimagesize($src);
    $width = $info[0] - 40;
    $height = $info[1] - 8;
    //3、获取图片类型
    $type = image_type_to_extension($info[2], false);
    //4、在内存中创建一个和我们图像类型一样的图像
    $func = "imagecreatefrom{$type}";
    //5、把图片复制到我们的内存中
    $image = $func($src);

    /* 操作图片 */
    //1、设置字体路径
    $font = "./font/hp.ttf";
    //2、填写水印内容
    $topWater = env('TOP_WATER', 'JKD');
    $bottomWater = env('BOTTOM_WATER', 'crytjy');
    //3、设置字体颜色和透明度
    $color = imagecolorallocatealpha($image, 0, 0, 0, 50);
    //4、写入文字
    imagettftext($image, 10, 0, 6, 15, $color, $font, $topWater);
    imagettftext($image, 10, 0, $width, $height, $color, $font, $bottomWater);

    /* 输出图片 */
    header("Content-type:" . $info['mime']);
    $outputfunc = "image{$type}";
    //1、浏览器输出
//    $outputfunc($image);
    //2、保存图片
    $outputfunc($image, $filePath);

    /* 销毁图片 */
    imagedestroy($image);

    return true;
}
