<?php

namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\TransferClient;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricDecryptRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DecryptRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Darabonba\OpenApi\Models\Config;
use Exception;

class DecryptSample
{
    /**
     * 新接入用户可以参考此方法调用KMS实例网关的服务。
     */
    private static function newUserDecryptSample()
    {
        // 创建kms实例网关config并设置相应参数
        $dkmsConfig = new \AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config([
            // 设置请求协议为https
            "protocol" => "https",
            // 设置clientKey文件路径
            "clientKeyFile" => "your-client-key-file-path",
            // 设置clientKey密码
            "password" => getenv("your-client-key-password-env"),
            // 设置kms实例服务地址
            "endpoint" => "your-kms-instance-endpoint",
            // 设置ssl验证标识,默认为false,即需验证ssl证书;为true时,可在调用接口时设置是否忽略ssl证书
            "ignoreSSL" => false,
            // 如需验证服务端证书，这里需要设置为您的服务端证书路径
            "caFilePath" => "path/to/yourCaCert",
        ]);
        $client = new TransferClient(null, $dkmsConfig);
        self::decrypt($client);
    }

    /**
     * 密钥迁移前示例代码
     */
    private static function beforeMigrateDecryptSample()
    {
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
        self::decrypt($client);
    }

    /**
     * 密钥迁移后示例代码
     */
    private static function afterMigrateDecryptSample()
    {
        // 创建kms共享网关config并设置相应参数
        $openapiConfig = new Config([
            // 设置访问凭证AccessKeyId
            "accessKeyId" => getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"),
            // 设置访问凭证AccessKeySecret
            "accessKeySecret" => getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET"),
            // 设置KMS共享网关的地域
            "regionId" => "your-region-id"
        ]);

        // 创建kms实例网关config并设置相应参数
        $dkmsConfig = new \AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config([
            // 设置请求协议为https
            "protocol" => "https",
            // 设置clientKey文件路径
            "clientKeyFile" => "your-client-key-file-path",
            // 设置clientKey密码
            "password" => getenv("your-client-key-password-env"),
            // 设置kms实例服务地址
            "endpoint" => "your-kms-instance-endpoint",
            // 设置ssl验证标识,默认为false,即需验证ssl证书;为true时,可在调用接口时设置是否忽略ssl证书
            "ignoreSSL" => false,
            // 如需验证服务端证书，这里需要设置为您的服务端证书路径
            "caFilePath" => "path/to/yourCaCert",
        ]);

        $client = new TransferClient($openapiConfig, $dkmsConfig);
        self::decrypt($client);
    }

    /**
     * @param TransferClient $client
     * @return void
     */
    private static function decrypt($client)
    {
        try {
            $decryptRequest = new DecryptRequest([
                "ciphertextBlob" => "your-ciphertext-blob"
            ]);

            $runtime = new RuntimeOptions([]);
            // 如需忽略SSL证书认证,可打开如下代码并设置ignoreSSL为true
            //$runtime->ignoreSSL = true;

            $response = $client->decryptWithOptions($decryptRequest, $runtime);
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
        self::newUserDecryptSample();
        self::beforeMigrateDecryptSample();
        self::afterMigrateDecryptSample();
    }
}

$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
DecryptSample::main(array_slice($argv, 1));