集成了 [百度](http://www.tuling123.com/) 官方的Api接口。

## 安装

 1. 安装包文件

	``` bash
	$ composer require jormin/laravel-baidu-speech
	```

## 配置

1. 注册 ServiceProvider:
	
	```php
	Jormin\BaiduSpeech\BaiduSpeechServiceProvider::class,
	```

2. 创建配置文件：

	```shell
	php artisan vendor:publish
	```
	
	执行命令后会在 `config` 目录下生成本扩展配置文件：`laravel-baidu-speech.php`。
	
3. 在 `.env` 文件中增加如下配置：

	- `BAIDU_APP_ID`：百度AppId。

	- `BAIDU_API_KEY`：百度ApiKey。

	- `BAIDU_SECRET_KEY`：百度SecretKey。

## 使用

1. 语音识别
    
    ```php
       Jormin\BaiduSpeech\BaiduSpeech::recognize($filePath, $url, $callback, $userID, $format, $rate, $lan);
    ```
     
    接口字段：
    
    | 参数  | 类型  | 说明  | 可为空  |
    | ------------ | ------------ | ------------ | ------------ |
    | filePath | String | 语音文件本地路径，该字段和url字段二选一，优先使用此项 | Y |
    | url | String | 语音文件URL路径，该字段和filePath字段二选一 | Y |
    | callback | String | 回调地址 | Y |
    | userID | String | 用户唯一标识 | Y |
    | format | String | 语音文件格式，可选值 ['pcm', 'wav', 'opus', 'speex', 'amr']，默认为wav | Y |
    | rate | Integer | 采样率，可选值 [8000, 16000]，默认为16000 | Y |
    | lan | String | 语言，可选值 ['zh', 'ct', 'en']，默认为zh | Y |
    
    接口返回字段详细见 [百度官方文档](https://cloud.baidu.com/doc/SPEECH/ASR-Online-PHP-SDK.html).

2. 语音合成
    
    ```php
       Jormin\BaiduSpeech\BaiduSpeech::combine($text, $userID, $lan, $speed, $pitch, $volume, $person);
    ```
         
    接口字段：
    
    | 参数  | 类型  | 说明  | 可为空  |
    | ------------ | ------------ | ------------ | ------------ |
    | text | String | 合成的文本 | N |
    | userID | String | 用户唯一标识 | Y |
    | lan | String | 语言，可选值 ['zh']，默认为zh | Y |
    | speed | Integer | 语速，取值0-9，默认为5中语速 | Y |
    | pitch | Integer | 音调，取值0-9，默认为5中语调 | Y |
    | volume | Integer | 音量，取值0-15，默认为5中音量 | Y |
    | person | Integer | 发音人选择, 0为女声，1为男声，3为情感合成-度逍遥，4为情感合成-度丫丫，默认为普通女 | Y |
    
    接口返回字段详细见 [百度官方文档](https://cloud.baidu.com/doc/SPEECH/TTS-Online-PHP-SDK.html).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
