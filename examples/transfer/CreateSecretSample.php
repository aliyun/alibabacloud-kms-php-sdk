<?php

namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\TransferClient;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateSecretRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use Darabonba\OpenApi\Models\Config;
use Exception;

class CreateSecretSample
{
    private static function createSecret()
    {
        try {
            // 创建kms共享网关config并设置相应参数
            $openapiConfig = new Config([
                // 设置访问凭证AccessKeyId
                "accessKeyId" => getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"),
                // 设置访问凭证AccessKeySecret
                "accessKeySecret" => getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET"),
                // 设置KMS共享网关的地域
                "regionId" => "your-region-id"
            ]);
            $client = new TransferClient($openapiConfig, null);
            $createSecretRequest = new CreateSecretRequest([
                "secretName" => "your-secret-name",
                "secretData" => "your-secret-data",
                "versionId" => "your-version-id"
            ]);
            $response = $client->createSecret($createSecretRequest);
            var_dump($response);
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            var_dump($error);
        }
    }

    public static function main($args)
    {
        self::createSecret();
    }
}

$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
CreateSecretSample::main(array_slice($argv, 1));