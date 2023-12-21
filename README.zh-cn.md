![](https://aliyunsdk-pages.alicdn.com/icons/AlibabaCloud.svg)

阿里云KMS PHP SDK
=====================

阿里云KMS PHP SDK可以帮助PHP开发者快速使用KMS。

*其他语言版本:*[English](README.md)*,*[简体中文](README.zh-cn.md)

-   [阿里云KMS主页](https://help.aliyun.com/document_detail/311016.html)
-   [代码示例](/examples)
-   [Issues](https://github.com/aliyun/alibabacloud-kms-php-sdk/issues)
-   [Release](https://github.com/aliyun/alibabacloud-kms-php-sdk/releases)

许可证
------ 

[Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0.html)

优势
------ 
帮助PHP开发者通过本SDK快速使用阿里云KMS产品的所有API：
- 支持通过KMS公共网关访问进行KMS资源管理和密钥运算
- 支持通过KMS实例网关进行密钥运算

软件要求
----------

- PHP 5.6 或以上版本

安装
----------

可以通过Composer的方式在项目中使用KMS PHP客户端。导入方式如下:

```
"require": {
     "alibabacloud/kms-kms20160120": "^0.4.0"
 }
```

然后通过运行以下命令安装依赖:

```
composer install
```

使用composer安装完成后，在您的PHP代码中引入依赖即可:

```
require_once __DIR__ . '/vendor/autoload.php';
```

KMS Client介绍
----------

| KMS 客户端类                                    | 简介 | 使用场景 |
|:--------------------------------------------| :---- | :---- |
| AlibabaCloud\Kms\Kms20160120\Client            | 支持KMS资源管理和KMS实例网关的密钥运算| 1.仅通过VPC网关进行密钥运算操作的场景。<br>2.仅通过公共网关对KMS资源管理的场景。 <br>3.既要通过VPC网关进行密钥运算操作又要通过公共网关对KMS资源管理的场景。|
| AlibabaCloud\Kms\Kms20160120\TransferClient | 支持用户应用简单修改的情况下就可以从KMS 1.0密钥运算迁移到 KMS 3.0密钥运算 | 使用阿里云 SDK访问KMS 1.0密钥运算的用户，需要迁移到KMS 3.0的场景。|

示例代码
----------
### 1. 仅通过VPC网关进行密钥运算操作的场景。
#### 参考以下示例代码调用KMS Encrypt API。更多API示例参考 [密钥运算示例代码](./examples/operation)
```php
class Encrypt {

    /**
     * @param string $clientKeyFile
     * @param string $password
     * @param string $endpoint
     * @param string $caFilePath
     * @return Config
     */
    public static function createKmsInstanceConfig($clientKeyFile, $password, $endpoint, $caFilePath){
        $config = new Config([
            "clientKeyFile" => $clientKeyFile,
            "password" => $password,
            "endpoint" => $endpoint,
            "caFilePath" => $caFilePath
        ]);
        return $config;
    }

    /**
     * @param Config $kmsInstanceConfig
     * @return KmsSdkClient
     */
    public static function createClient($kmsInstanceConfig){
        return new KmsSdkClient($kmsInstanceConfig, null);
    }

    /**
     * @param KmsSdkClient $client
     * @param string $paddingMode
     * @param int[] $aad
     * @param string $keyId
     * @param int[] $plaintext
     * @param int[] $iv
     * @param string $algorithm
     * @return EncryptResponse
     */
    public static function encrypt($client, $paddingMode, $aad, $keyId, $plaintext, $iv, $algorithm){
        $request = new EncryptRequest([
            "paddingMode" => $paddingMode,
            "aad" => $aad,
            "keyId" => $keyId,
            "plaintext" => $plaintext,
            "iv" => $iv,
            "algorithm" => $algorithm
        ]);
        return EncryptResponse::fromMap(Utils::toMap($client->encrypt($request)));
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function main($args){
        $kmsInstanceConfig = self::createKmsInstanceConfig(getenv("your client key file path env"), getenv("your client key password env"), "your kms instance endpoint", "your ca file path");
        $client = self::createClient($kmsInstanceConfig);
        $paddingMode = "your paddingMode";
        $aad = Utils::toBytes("your aad");
        $keyId = "your keyId";
        $plaintext = Utils::toBytes("your plaintext");
        $iv = Utils::toBytes("your iv");
        $algorithm = "your algorithm";
        $response = self::encrypt($client, $paddingMode, $aad, $keyId, $plaintext, $iv, $algorithm);
        Console::log(Utils::toJSONString($response));
    }
}
```
### 2. 仅通过公共网关对KMS资源管理的场景。
#### 参考以下示例代码调用KMS CreateKey API。更多API示例参考 [密钥管理代码示例](./examples/manage)
```php
class CreateKey {

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
     * @param string $keyUsage
     * @param string $origin
     * @param string $description
     * @param string $DKMSInstanceId
     * @param string $protectionLevel
     * @param string $keySpec
     * @return CreateKeyResponse
     */
    public static function createKey($client, $enableAutomaticRotation, $rotationInterval, $keyUsage, $origin, $description, $DKMSInstanceId, $protectionLevel, $keySpec){
        $request = new CreateKeyRequest([
            "enableAutomaticRotation" => $enableAutomaticRotation,
            "rotationInterval" => $rotationInterval,
            "keyUsage" => $keyUsage,
            "origin" => $origin,
            "description" => $description,
            "DKMSInstanceId" => $DKMSInstanceId,
            "protectionLevel" => $protectionLevel,
            "keySpec" => $keySpec
        ]);
        return $client->createKey($request);
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
        $keyUsage = "your keyUsage";
        $origin = "your origin";
        $description = "your description";
        $dKMSInstanceId = "your dKMSInstanceId";
        $protectionLevel = "your protectionLevel";
        $keySpec = "your keySpec";
        $response = self::createKey($client, $enableAutomaticRotation, $rotationInterval, $keyUsage, $origin, $description, $dKMSInstanceId, $protectionLevel, $keySpec);
        Console::log(Utils::toJSONString($response));
    }
}
```
### 3. 既要通过VPC网关进行密钥运算操作又要通过公共网关对KMS资源管理的场景。
#### 参考以下示例代码调用KMS CreateKey API 和 Encrypt API。更多API示例参考 [密钥运算示例代码](./examples/operation) 和 [密钥管理示例代码](./examples/manage)
```php

class Sample {

    //创建kms实例配置
    public static function createKmsInstanceConfig($clientKeyFile, $password, $endpoint, $caFilePath){
        $config = new Config([
            "clientKeyFile" => $clientKeyFile,
            "password" => $password,
            "endpoint" => $endpoint,
            "caFilePath" => $caFilePath
        ]);
        return $config;
    }

    //创建OpenApi配置
    public static function createOpenApiConfig($accessKeyId, $accessKeySecret, $regionId){
        $config = new Config([
            "accessKeyId" => $accessKeyId,
            "accessKeySecret" => $accessKeySecret,
            "regionId" => $regionId
        ]);
        return $config;
    }

    //创建Client 
    public static function createClient($kmsInstanceConfig, $openApiConfig){
        return new KmsSdkClient($kmsInstanceConfig, $openApiConfig);
    }

    public static function createKey($client, $enableAutomaticRotation, $rotationInterval, $keyUsage, $origin, $description, $DKMSInstanceId, $protectionLevel, $keySpec){
        $request = new CreateKeyRequest([
            "enableAutomaticRotation" => $enableAutomaticRotation,
            "rotationInterval" => $rotationInterval,
            "keyUsage" => $keyUsage,
            "origin" => $origin,
            "description" => $description,
            "DKMSInstanceId" => $DKMSInstanceId,
            "protectionLevel" => $protectionLevel,
            "keySpec" => $keySpec
        ]);
        return $client->createKey($request);
    }

    public static function encrypt($client, $paddingMode, $aad, $keyId, $plaintext, $iv, $algorithm){
        $request = new EncryptRequest([
            "paddingMode" => $paddingMode,
            "aad" => $aad,
            "keyId" => $keyId,
            "plaintext" => $plaintext,
            "iv" => $iv,
            "algorithm" => $algorithm
        ]);
        return EncryptResponse::fromMap(Utils::toMap($client->encrypt($request)));
    }

    public static function main($args){
        $kmsInstanceConfig = self::createKmsInstanceConfig(getenv("your client key file path env"), getenv("your client key password env"), "your kms instance endpoint", "your ca file path");
        // 请确保代码运行环境设置了环境变量 ALIBABA_CLOUD_ACCESS_KEY_ID 和 ALIBABA_CLOUD_ACCESS_KEY_SECRET。
        // 工程代码泄露可能会导致 AccessKey 泄露，并威胁账号下所有资源的安全性。以下代码示例使用环境变量获取 AccessKey 的方式进行调用，仅供参考，建议使用更安全的 STS 方式，更多鉴权访问方式请参见：https://help.aliyun.com/document_detail/378657.html
        $openApiConfig = self::createOpenApiConfig(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET"), "your region id");
        $client = self::createClient($kmsInstanceConfig, $openApiConfig);
        $enableAutomaticRotation = false;
        $rotationInterval = "your rotationInterval";
        $keyUsage = "your keyUsage";
        $origin = "your origin";
        $description = "your description";
        $dKMSInstanceId = "your dKMSInstanceId";
        $protectionLevel = "your protectionLevel";
        $keySpec = "your keySpec";
        $response = self::createKey($client, $enableAutomaticRotation, $rotationInterval, $keyUsage, $origin, $description, $dKMSInstanceId, $protectionLevel, $keySpec);
        Console::log(Utils::toJSONString($response));

        $paddingMode = "your paddingMode";
        $aad = Utils::toBytes("your aad");
        $keyId = "your keyId";
        $plaintext = Utils::toBytes("your plaintext");
        $iv = Utils::toBytes("your iv");
        $algorithm = "your algorithm";
        $response = self::encrypt($client, $paddingMode, $aad, $keyId, $plaintext, $iv, $algorithm);
        Console::log(Utils::toJSONString($response));
    }
}

```
### 使用阿里云 SDK访问KMS 1.0密钥运算的用户，需要迁移到KMS 3.0的场景。
#### 参考以下示例代码调用KMS API。更多API示例参考 [KMS迁移代码示例](./examples/transfer)
```php

use AlibabaCloud\Kms\Kms20160120\TransferClient;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateDataKeyRequest;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Darabonba\OpenApi\Models\Config;
use Exception;

public class Sample {

    public static function createClient() {
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
            //创建kms client
            return new TransferClient($openapiConfig, $dkmsConfig);
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            var_dump($error);
        }
    }

    /**
     * 创建密钥调用KMS共享网关
     */
    private static function createKey($client) {
        try {
            $createKeyRequest = new CreateKeyRequest([
                "DKMSInstanceId" => "your-dkms-instance-id"
            ]);
            $response = $client->createKey($createKeyRequest);
            var_dump($response);
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            var_dump($error);
        }
    }

    /**
     * 生成数据密钥调用KMS实例网关
     */
    private static function generateDataKey($client){
        try {
            $generateDataKeyRequest = new GenerateDataKeyRequest([
                "keyId" => "your-key-id"
            ]);
            $response = $client->generateDataKey($generateDataKeyRequest);
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
        $client = self::createClient();
        self::createKey($client);
        self::generateDataKey($client);
    }
}

$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Sample::main(array_slice($argv, 1));
```

版权所有 2009-present, 阿里巴巴集团.
