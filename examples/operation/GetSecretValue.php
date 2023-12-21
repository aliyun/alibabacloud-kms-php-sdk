<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\Client as KmsSdkClient;
use AlibabaCloud\Tea\Utils\Utils;

use AlibabaCloud\Tea\Console\Console;

use AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GetSecretValueResponse;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GetSecretValueRequest;

class Client {

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
     * @param bool $fetchExtendedConfig
     * @param string $secretName
     * @param string $versionId
     * @param string $versionStage
     * @return GetSecretValueResponse
     */
    public static function getSecretValue($client, $fetchExtendedConfig, $secretName, $versionId, $versionStage){
        $request = new GetSecretValueRequest([
            "fetchExtendedConfig" => $fetchExtendedConfig,
            "secretName" => $secretName,
            "versionId" => $versionId,
            "versionStage" => $versionStage
        ]);
        return GetSecretValueResponse::fromMap(Utils::toMap($client->getSecretValue($request)));
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function main($args){
        $kmsInstanceConfig = self::createKmsInstanceConfig(getenv("your client key file path env"), getenv("your client key password env"), "your kms instance endpoint", "your ca file path");
        $client = self::createClient($kmsInstanceConfig);
        $fetchExtendedConfig = false;
        $secretName = "your secretName";
        $versionId = "your versionId";
        $versionStage = "your versionStage";
        $response = self::getSecretValue($client, $fetchExtendedConfig, $secretName, $versionId, $versionStage);
        Console::log(Utils::toJSONString($response));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Client::main(array_slice($argv, 1));
