<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\Client as KmsSdkClient;

use AlibabaCloud\Tea\Utils\Utils;
use AlibabaCloud\Tea\Console\Console;

use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateSecretRequest;

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
     * @param bool $enableAutomaticRotation
     * @param string $rotationInterval
     * @param string $encryptionKeyId
     * @param string $secretName
     * @param string $versionId
     * @param string $secretDataType
     * @param string $secretType
     * @param string $description
     * @param string $DKMSInstanceId
     * @param string $secretData
     * @param string $tags
     * @return CreateSecretResponse
     */
    public static function createSecret($client, $enableAutomaticRotation, $rotationInterval, $encryptionKeyId, $secretName, $versionId, $secretDataType, $secretType, $description, $DKMSInstanceId, $secretData, $tags){
        $request = new CreateSecretRequest([
            "enableAutomaticRotation" => $enableAutomaticRotation,
            "rotationInterval" => $rotationInterval,
            "encryptionKeyId" => $encryptionKeyId,
            "secretName" => $secretName,
            "versionId" => $versionId,
            "secretDataType" => $secretDataType,
            "secretType" => $secretType,
            "description" => $description,
            "DKMSInstanceId" => $DKMSInstanceId,
            "secretData" => $secretData,
            "tags" => $tags
        ]);
        return $client->createSecret($request);
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
        $enableAutomaticRotation = false;
        $rotationInterval = "your rotationInterval";
        $encryptionKeyId = "your encryptionKeyId";
        $secretName = "your secretName";
        $versionId = "your versionId";
        $secretDataType = "your secretDataType";
        $secretType = "your secretType";
        $description = "your description";
        $dKMSInstanceId = "your dKMSInstanceId";
        $secretData = "your secretData";
        $tags = "your tags";
        $response = self::createSecret($client, $enableAutomaticRotation, $rotationInterval, $encryptionKeyId, $secretName, $versionId, $secretDataType, $secretType, $description, $dKMSInstanceId, $secretData, $tags);
        Console::log(Utils::toJSONString($response));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Client::main(array_slice($argv, 1));
