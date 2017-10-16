<?php

namespace Jormin\BaiduSpeech;

use Jormin\BaiduSpeech\Libs\AipSpeech;

/**
 * 百度语音SDK库
 * @package Jormin\BaiduSpeech
 */
class BaiduSpeech{

    /**
     * @return array
     */
    public static function loadConfig()
    {
        $config = [
            'appID'  => config('laravel-baidu-speech.app_id'),
            'apiKey' => config('laravel-baidu-speech.api_key'),
            'secretKey' => config('laravel-baidu-speech.secret_key'),
        ];
        return $config;
    }

    /**
     * 语音识别
     *
     * @param $filePath string 语音文件本地路径,优先使用此项
     * @param $url string 语音文件URL路径
     * @param $callback string 回调地址
     * @param $format string 语音文件格式 ['pcm', 'wav', 'opus', 'speex', 'amr']
     * @param $rate integer 采样率 [8000, 16000]
     * @param $lan string 语音 ['zh', 'ct', 'en']
     * @return array
     */
    public static function recognize($filePath, $url, $callback, $format='wav', $rate=16000, $lan='zh')
    {
        $return = ['success'=>false, 'msg'=>'网络超时'];
        if(!$filePath && !$url){
            $return['msg'] = '语音文件本地路径或URL路径需要至少提供一个';
            return $return;
        }
        if($filePath && !file_exists($filePath)){
            $return['msg'] = '语音文件路径错误';
            return $return;
        }
        if(!in_array($format, ['pcm', 'wav', 'opus', 'speex', 'amr'])){
            $return['msg'] = '语音文件格式错误,当前支持以下格式:pcm（不压缩）、wav、opus、speex、amr';
            return $return;
        }
        if(!in_array($rate, [8000, 16000])){
            $return['msg'] = '采样率错误，当前支持8000或者16000';
            return $return;
        }
        if(!in_array($lan, ['zh', 'ct', 'en'])){
            $return['msg'] = '语言错误，当前支持中文(zh)、粤语(ct)、英文(en)';
            return $return;
        }
        $config = self::loadConfig();
        $aipSpeech = new AipSpeech($config['appID'], $config['apiKey'], $config['secretKey']);
        $options = [
            'lan' => $lan
        ];
        if(!$filePath && $url){
            $options['url'] = $url;
        }
        if($callback){
            $options['callback'] = $callback;
        }
        $response = $aipSpeech->asr($filePath ? file_get_contents($filePath) : null, $format, $rate, $options);
        if($response['err_no'] == 0){
            $return = [
                'success' => true,
                'msg' => '语音识别成功',
                'data' => $response['result']
            ];
        }else{
            $return['msg'] = '语音识别错误,错误码:'.$response['error_code'].',错误信息:'.$response['error_msg'];
        }
        return $return;
    }
}