<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\Client as KmsSdkClient;
use AlibabaCloud\Tea\Utils\Utils;

use AlibabaCloud\Tea\Console\Console;

use AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GenerateDataKeyPairWithoutPlaintextResponse;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GenerateDataKeyPairWithoutPlaintextRequest;

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
     * @param string $algorithm
     * @return GenerateDataKeyPairWithoutPlaintextResponse
     */
    public static function generateDataKeyPairWithoutPlaintext($client, $keyFormat, $aad, $keyId, $keyPairSpec, $algorithm){
        $request = new GenerateDataKeyPairWithoutPlaintextRequest([
            "keyFormat" => $keyFormat,
            "aad" => $aad,
            "keyId" => $keyId,
            "keyPairSpec" => $keyPairSpec,
            "algorithm" => $algorithm
        ]);
        return GenerateDataKeyPairWithoutPlaintextResponse::fromMap(Utils::toMap($client->generateDataKeyPairWithoutPlaintext($request)));
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
        $algorithm = "your algorithm";
        $response = self::generateDataKeyPairWithoutPlaintext($client, $keyFormat, $aad, $keyId, $keyPairSpec, $algorithm);
        Console::log(Utils::toJSONString($response));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Client::main(array_slice($argv, 1));
