<?php

namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\TransferClient;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateDataKeyRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use Darabonba\OpenApi\Models\Config;
use Exception;


class EnvelopeEncryptSample
{
    /**
     * 新接入用户可以参考此方法调用KMS实例网关的服务。
     */
    private static function newUserEnvelopeEncrypt()
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
        self::envelopeEncrypt($client);
    }

    /**
     * 密钥迁移前示例代码
     */
    private static function beforeMigrateEnvelopeEncrypt()
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
        self::envelopeEncrypt($client);
    }

    /**
     * 密钥迁移后示例代码
     */
    private static function afterMigrateEnvelopeEncrypt()
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
        self::envelopeEncrypt($client);
    }

    /**
     * @param TransferClient $client
     * @return void
     */
    private static function envelopeEncrypt($client)
    {
        try {
            $generateDataKeyRequest = new GenerateDataKeyRequest([
                "keyId" => "your-key-id"
            ]);
            $generateDataKeyResponse = $client->generateDataKey($generateDataKeyRequest);
            // KMS返回的数据密钥明文, 加密本地数据使用
            $dataKey = base64_decode($generateDataKeyResponse->body->plaintext);
            // 数据密钥密文
            $dataKeyBlob = $generateDataKeyResponse->body->ciphertextBlob;
            // 使用KMS返回的数据密钥明文在本地对数据进行加密，下面以AES-256 CBC模式为例
            $data = "your plaintext data";
            $ivLen = openssl_cipher_iv_length('aes-256-cbc');
            $iv = openssl_random_pseudo_bytes($ivLen);
            $ciphertext = openssl_encrypt($data, 'aes-256-cbc', $dataKey, OPENSSL_RAW_DATA, $iv);

            // 输出密文，密文输出或持久化由用户根据需要进行处理，下面示例仅展示将密文输出到一个对象的情况
            // 假如envelope_cipher_text是需要输出的密文对象，至少需要包括以下三个内容:
            // (1) EncryptedDataKey: KMS返回的数据密钥密文
            // (2) iv: 加密初始向量
            // (3) CipherText: 密文数据
            $envelope_cipher_text = new EnvelopeCipherPersistObject();
            $envelope_cipher_text->iv = base64_encode($iv);
            $envelope_cipher_text->cipherText = base64_encode($ciphertext);
            $envelope_cipher_text->encryptedDataKey = $dataKeyBlob;
            var_dump($envelope_cipher_text);
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            var_dump($error);
        }
    }

    public static function main($args)
    {
        self::newUserEnvelopeEncrypt();
        self::beforeMigrateEnvelopeEncrypt();
        self::afterMigrateEnvelopeEncrypt();
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
EnvelopeEncryptSample::main(array_slice($argv, 1));