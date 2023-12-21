<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\Client as KmsSdkClient;

use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Console\Console;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteKeyMaterialResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteKeyMaterialRequest;

class Client {

    /**
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @param string $regionId
     * @return Config
     */
    public static function createOpenApiConfig($accessKeyId, $accessKeySecret, $regionId){
        $config = new Config([
            "accessKeyId" => $accessKeyId,
            "accessKeySecret" => $accessKeySecret,
            "regionId" => $regionId
        ]);
        return $config;
    }

    /**
     * @param Config $openApiConfig
     * @return KmsSdkClient
     */
    public static function createClient($openApiConfig){
        return new KmsSdkClient(null, $openApiConfig);
    }

    /**
     * @param KmsSdkClient $client
     * @param string $keyId
     * @return DeleteKeyMaterialResponse
     */
    public static function deleteKeyMaterial($client, $keyId){
        $request = new DeleteKeyMaterialRequest([
            "keyId" => $keyId
        ]);
        return $client->deleteKeyMaterial($request);
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function main($args){
        // 请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_ID 和 ALIBABA_CLOUD_ACCESS_KEY_SECRET。
        // 工程代码泄露可能会导致 AccessKey 泄露，并威胁账号下所有资源的安全性。以下代码示例使用环境变量获取 AccessKey 的方式进行调用，仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/378657.html
        $openApiConfig = self::createOpenApiConfig(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET"), "your region id");
        $client = self::createClient($openApiConfig);
        $keyId = "your keyId";
        $response = self::deleteKeyMaterial($client, $keyId);
        Console::log(Utils::toJSONString($response));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Client::main(array_slice($argv, 1));
