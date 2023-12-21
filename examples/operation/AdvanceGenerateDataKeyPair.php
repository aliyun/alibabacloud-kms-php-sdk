<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\Client as KmsSdkClient;
use AlibabaCloud\Tea\Utils\Utils;

use AlibabaCloud\Tea\Console\Console;

use AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceGenerateDataKeyPairResponse;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceGenerateDataKeyPairRequest;

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
     * @param string $keyFormat
     * @param int[] $aad
     * @param string $keyId
     * @param string $keyPairSpec
     * @return AdvanceGenerateDataKeyPairResponse
     */
    public static function advanceGenerateDataKeyPair($client, $keyFormat, $aad, $keyId, $keyPairSpec){
        $request = new AdvanceGenerateDataKeyPairRequest([
            "keyFormat" => $keyFormat,
            "aad" => $aad,
            "keyId" => $keyId,
            "keyPairSpec" => $keyPairSpec
        ]);
        return AdvanceGenerateDataKeyPairResponse::fromMap(Utils::toMap($client->advanceGenerateDataKeyPair($request)));
    }

    /**
     * @param string[] $args
     * @return void
     */
    public static function main($args){
        $kmsInstanceConfig = self::createKmsInstanceConfig(getenv("your client key file path env"), getenv("your client key password env"), "your kms instance endpoint", "your ca file path");
        $client = self::createClient($kmsInstanceConfig);
        $keyFormat = "your keyFormat";
        $aad = Utils::toBytes("your aad");
        $keyId = "your keyId";
        $keyPairSpec = "your keyPairSpec";
        $response = self::advanceGenerateDataKeyPair($client, $keyFormat, $aad, $keyId, $keyPairSpec);
        Console::log(Utils::toJSONString($response));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Client::main(array_slice($argv, 1));
