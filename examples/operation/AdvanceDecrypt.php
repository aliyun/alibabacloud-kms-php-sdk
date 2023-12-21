<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120\Samples;

use AlibabaCloud\Kms\Kms20160120\Client as KmsSdkClient;
use AlibabaCloud\Tea\Utils\Utils;

use AlibabaCloud\Tea\Console\Console;

use AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceDecryptResponse;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceDecryptRequest;

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
     * @param string $paddingMode
     * @param int[] $aad
     * @param int[] $ciphertextBlob
     * @param string $keyId
     * @param int[] $iv
     * @param string $algorithm
     * @return AdvanceDecryptResponse
     */
    public static function advanceDecrypt($client, $paddingMode, $aad, $ciphertextBlob, $keyId, $iv, $algorithm){
        $request = new AdvanceDecryptRequest([
            "paddingMode" => $paddingMode,
            "aad" => $aad,
            "ciphertextBlob" => $ciphertextBlob,
            "keyId" => $keyId,
            "iv" => $iv,
            "algorithm" => $algorithm
        ]);
        return AdvanceDecryptResponse::fromMap(Utils::toMap($client->advanceDecrypt($request)));
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
        $ciphertextBlob = Utils::toBytes("your ciphertextBlob");
        $keyId = "your keyId";
        $iv = Utils::toBytes("your iv");
        $algorithm = "your algorithm";
        $response = self::advanceDecrypt($client, $paddingMode, $aad, $ciphertextBlob, $keyId, $iv, $algorithm);
        Console::log(Utils::toJSONString($response));
    }
}
$path = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . 'vendor' . \DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($path)) {
    require_once $path;
}
Client::main(array_slice($argv, 1));
