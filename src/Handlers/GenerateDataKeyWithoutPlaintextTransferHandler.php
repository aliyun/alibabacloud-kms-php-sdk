<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\EncryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GenerateDataKeyRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GenerateDataKeyResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\EncryptionContextUtils;
use AlibabaCloud\Kms\Kms20160120\Utils\KmsErrorCodeTransferUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class GenerateDataKeyWithoutPlaintextTransferHandler extends KmsTransferHandler
{
    /**
     * @param Client $client
     * @param KmsConfig $config
     */
    public function __construct($client, $config = null)
    {
        $this->client = $client;
        $this->kmsConfig = $config;
    }

    /**
     * @param OpenApiRequest $request
     * @param KmsRuntimeOptions $runtimeOptions
     * @return GenerateDataKeyRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        $numberOfBytes = isset($query["NumberOfBytes"]) ? $query["NumberOfBytes"] : null;
        if (AlibabaCloudTeaUtils::isUnset($numberOfBytes)) {
            $keySpec = isset($query["KeySpec"]) ? $query["KeySpec"] : null;
            if (empty($keySpec) || $keySpec === Constants::KMS_KEY_PAIR_AES_256) {
                $numberOfBytes = Constants::NUMBER_OF_BYTES_AES_256;
            } elseif ($keySpec === Constants::KMS_KEY_PAIR_AES_128) {
                $numberOfBytes = Constants::NUMBER_OF_BYTES_AES_128;
            } else {
                throw new TeaError([
                    "code" => KmsErrorCodeTransferUtils::INVALID_PARAMETER_ERROR_CODE,
                    "message" => KmsErrorCodeTransferUtils::INVALID_PARAMETER_KEY_SPEC_ERROR_MESSAGE,
                ]);
            }
        }
        $generateDataKeyWithoutPlaintextDKmsRequest = new GenerateDataKeyRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "numberOfBytes" => $numberOfBytes,
        ]);
        if (array_key_exists("EncryptionContext", $query)) {
            $generateDataKeyWithoutPlaintextDKmsRequest->aad = EncryptionContextUtils::encodeEncryptionContext($query["EncryptionContext"]);
        }
        return $generateDataKeyWithoutPlaintextDKmsRequest;
    }

    /**
     * @param $dkmsRequest
     * @param $runtimeOptions
     * @return GenerateDataKeyResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        $generateDataKeyResponse = $this->client->generateDataKeyWithOptions($dkmsRequest, $dkmsRuntimeOptions);

        $encryptRequest = new EncryptRequest([
            "keyId" => $dkmsRequest->keyId,
            "plaintext" => base64_encode(AlibabaCloudTeaUtils::toString($generateDataKeyResponse->plaintext)),
            "aad" => $dkmsRequest->aad,
        ]);
        $encryptResponse = $this->client->encryptWithOptions($encryptRequest, $dkmsRuntimeOptions);

        $generateDataKeyResponse->ciphertextBlob = $encryptResponse->ciphertextBlob;
        $generateDataKeyResponse->iv = $encryptResponse->iv;
        return $generateDataKeyResponse;
    }

    /**
     * @param GenerateDataKeyResponse $response
     * @param $runtimeOptions $runtimeOptions
     * @return array
     * @throws Exception
     */
    public function transferToOpenApiResponse($response, $runtimeOptions)
    {
        $responseHeaders = $response->responseHeaders;
        if (AlibabaCloudTeaUtils::isUnset($responseHeaders) || empty($responseHeaders) || AlibabaCloudTeaUtils::isUnset($responseHeaders[Constants::MIGRATION_KEY_VERSION_ID_KEY])) {
            throw new Exception(sprintf("Can not found response headers parameter[%s]", Constants::MIGRATION_KEY_VERSION_ID_KEY));
        }
        $keyVersionId = $responseHeaders[Constants::MIGRATION_KEY_VERSION_ID_KEY];
        $ciphertextBlob = array_merge(AlibabaCloudTeaUtils::toBytes($keyVersionId), $response->iv, $response->ciphertextBlob);
        $generateDataKeyWithoutPlaintextResponseBody = [
            "CiphertextBlob" => base64_encode(AlibabaCloudTeaUtils::toString($ciphertextBlob)),
            "KeyId" => $response->keyId,
            "KeyVersionId" => $keyVersionId,
            "RequestId" => $response->requestId,
        ];
        return [
            "body" => $generateDataKeyWithoutPlaintextResponseBody,
            "headers" => $response->responseHeaders,
            "statusCode" => Constants::HTTP_OK
        ];
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @var Client
     */
    public $client;

    /**
     * @var KmsConfig
     */
    public $kmsConfig;

    /**
     * @var string
     */
    public $action;

}