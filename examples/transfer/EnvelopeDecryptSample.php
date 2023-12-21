<?php

namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\TransferClient;
use AlibabaCloud\SDK\Kms\V20160120\Models\DecryptRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use Darabonba\OpenApi\Models\Config;
use Exception;

class EnvelopeDecryptSample
{
    /**
     * 新接入用户可以参考此方法调用KMS实例网关的服务。
     */
    private static function newUserEnvelopeDecrypt()
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
        self::envelopeDecrypt($client);
    }

    /**
     * 密钥迁移前示例代码
     */
    private static function beforeMigrateEnvelopeDecrypt()
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
        self::envelopeDecrypt($client);
    }

    /**
     * 密钥迁移后示例代码
     */
    private static function afterMigrateEnvelopeDecrypt()
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
        self::envelopeDecrypt($client);
    }

    /**
     * @param TransferClient $client
     * @return void
     */
    private static function envelopeDecrypt($client)
    {
        $envelopeCipherPersistObject = self::getEnvelopeCipherPersistObject();
        $encryptedDataKey = $envelopeCipherPersistObject->encryptedDataKey;
        $iv = base64_decode($envelopeCipherPersistObject->iv);
        $cipherText = base64_decode($envelopeCipherPersistObject->cipherText);
        try {
            $decryptRequest = new DecryptRequest([
                "ciphertextBlob" => $encryptedDataKey
            ]);
            $decryptResponse = $client->decrypt($decryptRequest);
            $key = base64_decode($decryptResponse->body->plaintext);
            $decryptedData = openssl_decrypt($cipherText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            var_dump($decryptedData);

        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            var_dump($error);
        }
    }

    /**
     * @return EnvelopeCipherPersistObject
     */
    private static function getEnvelopeCipherPersistObject()
    {
        // TODO 用户需要在此处代码进行替换，从存储中读取封信加密持久化对象
        return new EnvelopeCipherPersistObject();
    }

    public static function main($args)
    {
        self::newUserEnvelopeDecrypt();
        self::beforeMigrateEnvelopeDecrypt();
        self::afterMigrateEnvelopeDecrypt();
    }
}

class EnvelopeCipherPersistObject
{
    /**
     * @var string
     */
    public $encryptedDataKey;
    /**
     * @var string
     */
    public $iv;
    /**
     * @var string
     */
    public $cipherText;
}

$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
EnvelopeDecryptSample::main(array_slice($argv, 1));