<?php

/**
 * 自定义的辅助函数
 *
 */
namespace huangjian;

class my {
    public function __construct()
    {
        #构造函数
    }

    /**
     * 记录内容或者log
     * @param $content 记录的内容
     */
    function log($content)
    {
        date_default_timezone_set('PRC');

        $log = date('Y-m-d') . '.log';
        if (is_file($log)) {
            $file = fopen($log, 'a');
        } else {
            $file = fopen($log, 'w');
        }

        fwrite($file, print_r([
            'time'  => date('Y-m-d H:i:s'),
            'route' => $_SERVER['REQUEST_URI'],
            'get'   => $_GET,
            'post'  => $_POST,
            'log'   => $content
        ], true));

        return true;

    }

    function i($arr, $method = 'get')
    {
        if ($method == 'get') {
            $input = $_GET;
        } elseif ($method == 'post') {
            $input = $_POST;
        } else {
            throw new Exception('获取输入参数的方法未指定');
        }

        if (!is_array($arr)) {
            return $input;
        }

        $return = [];
        foreach ($arr as $value) {
            if (isset($input[$value])) {
                $return[$value] = $input[$value];
            }
        }
        return $return;
    }

    /**
     * 输出函数
     */
    function o($arr)
    {
        echo '<pre>';
        var_dump($arr);
        echo '</pre>';
        exit;
    }

    /**
     * 使用file_get_content发送post请求
     * @param string $url 请求地址
     * @param array $post_data post键值对数据
     * @return string
     */
    function send_post($url, $post_data) {

        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return $result;
    }
}
