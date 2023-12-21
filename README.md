![](https://aliyunsdk-pages.alicdn.com/icons/AlibabaCloud.svg)

Alibaba Cloud KMS SDK for PHP
=================================

Alibaba Cloud KMS SDK for PHP can help PHP developers to use KMS.

*Read this in other
languages:*[English](README.md)*,*[简体中文](README.zh-cn.md)

-   [Alibaba Cloud KMS Homepage](https://www.alibabacloud.com/help/zh/doc-detail/311016.htm)
-   [Sample Code](/example)
-   [Issues](https://github.com/aliyun/alibabacloud-kms-php-sdk/issues)
-   [Release](https://github.com/aliyun/alibabacloud-kms-php-sdk/releases)

License
-------

[Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0.html)

Advantage
------ 
Alibaba Cloud KMS PHP SDK helps PHP developers quickly use all APIs of Alibaba Cloud KMS products:
- KMS resource management and key operations can be performed through KMS public gateway access
- You can perform key operations through KMS instance gateway


Requirements
--------

- PHP 5.6 or later

Install
--------

The recommended way to use the Alibaba Cloud KMS SDK for PHP in your project is to consume it from Composer. Import as follows:

```
"require": {
     "alibabacloud/kms-kms20160120": "^0.4.0"
 }
```

Then run the following to install the dependency:

```
composer install
```

After the Composer Dependency Manager is installed, import the dependency in your PHP code:

```
require_once __DIR__ . '/vendor/autoload.php';
```

Introduction to KMS Client
----------

| KMS client classes                        | Introduction | Usage scenarios |
|:------------------------------------------| :---- | :---- |
| AlibabaCloud\Kms\Kms20160120\Client         | KMS resource management and key operations for KMS instance gateways are supported | 1. Scenarios where key operations are performed only through VPC gateways. <br>2. KMS resource management scenarios that only use public gateways. <br>3. Scenarios where you want to perform key operations through VPC gateways and manage KMS resources through public gateways.|
| AlibabaCloud\Kms\Kms20160120\TransferClient | Users can migrate from KMS 1.0 key operations to KMS 3.0 key operations | Users who use Alibaba Cloud SDK to access KMS 1.0 key operations need to migrate to KMS 3.0 |

Sample code
----------
### 1. Scenarios where key operations are performed only through VPC gateways.
#### Refer to the following sample code to call the KMS Encrypt API. For more API examples, see [operation samples](./examples/operation)
```php
public class Encrypt {

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
### 2. KMS resources are managed only through public gateways.
#### Refer to the following sample code to call the KMS CreateKey API. For more API examples, see [manage samples](./examples/manage)

```php
public class CreateKey {

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
         //Make sure that the environment in which the code runs has environment variables ALIBABA_CLOUD_ACCESS_KEY_ID and ALIBABA_CLOUD_ACCESS_KEY_SECRET set.
         //Project code leakage may cause AccessKey to be leaked and threaten the security of all resources under the account. The following code example uses an environment variable to obtain the AccessKey for reference only, it is recommended to use the more secure STS mode, for more authentication access methods, see https://help.aliyun.com/document_detail/378657.html
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
### 3. You must not only perform key operations through a VPC gateway, but also manage KMS resources through a public gateway.
#### Refer to the following sample code to call the KMS CreateKey API and the Encrypt API. For more API examples, see [operation samples](./examples/operation) and [manage samples](./examples/manage)
```php
public class Sample {

    public static function createKmsInstanceConfig($clientKeyFile, $password, $endpoint, $caFilePath){
        $config = new Config([
            "clientKeyFile" => $clientKeyFile,
            "password" => $password,
            "endpoint" => $endpoint,
            "caFilePath" => $caFilePath
        ]);
        return $config;
    }

    public static function createOpenApiConfig($accessKeyId, $accessKeySecret, $regionId){
        $config = new Config([
            "accessKeyId" => $accessKeyId,
            "accessKeySecret" => $accessKeySecret,
            "regionId" => $regionId
        ]);
        return $config;
    }

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
        //Make sure that the environment in which the code runs has environment variables ALIBABA_CLOUD_ACCESS_KEY_ID and ALIBABA_CLOUD_ACCESS_KEY_SECRET set.
        //Project code leakage may cause AccessKey to be leaked and threaten the security of all resources under the account. The following code example uses an environment variable to obtain the AccessKey for reference only, it is recommended to use the more secure STS mode, for more authentication access methods, see https://help.aliyun.com/document_detail/378657.html
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
### Users who uses Alibaba Cloud SDK to access KMS 1.0 keys need to migrate to access KMS 3.0 keys.
#### Refer to the following sample code to call the KMS API. For more API examples, see [kms transfer samples](./examples/transfer)
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
            //set kms config
            $openapiConfig = new Config([
                //set accessKeyId
                "accessKeyId" => getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"),
                //set accessKeySecret
                "accessKeySecret" => getenv("ALIBABA_CLOUD_ACCESS_KEY_SECRET"),
                //set regionId
                "regionId" => "your-region-id"
            ]);

            //set kms instance config
            $dkmsConfig = new \AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config([
            //set the request protocol to https
            "protocol" => "https",
            //set client key file path
            "clientKeyFile" => "your-client-key-file-path",
            //set client key password
            "password" => getenv("your-client-key-password-env"),
            //set instance endpoint
            "endpoint" => "your-kms-instance-endpoint",
            //set your KMS instance's CA certificate with the file path
            "caFilePath" => "path/to/yourCaCert",
            ]);
            //create kms client
            return new TransferClient($openapiConfig, $dkmsConfig);
        } catch (Exception $error) {
            if (!($error instanceof TeaError)) {
                $error = new TeaError([], $error->getMessage(), $error->getCode(), $error);
            }
            var_dump($error);
        }
    }

    /**
     * create key
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
     * generate data key
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

Copyright (c) 2009-present, Alibaba Cloud All rights reserved.
