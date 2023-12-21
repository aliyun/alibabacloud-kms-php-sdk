<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceEncryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceGenerateDataKeyRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceGenerateDataKeyResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\EncryptionContextUtils;
use AlibabaCloud\Kms\Kms20160120\Utils\KmsErrorCodeTransferUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class AdvanceGenerateDataKeyWithoutPlaintextTransferHandler extends KmsTransferHandler
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
     * @return AdvanceGenerateDataKeyRequest
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
        $advanceGenerateDataKeyDKmsRequest = new AdvanceGenerateDataKeyRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "numberOfBytes" => $numberOfBytes,
        ]);
        if (array_key_exists("EncryptionContext", $query)) {
            $advanceGenerateDataKeyDKmsRequest->aad = EncryptionContextUtils::encodeEncryptionContext($query["EncryptionContext"]);
        }
        return $advanceGenerateDataKeyDKmsRequest;
    }

    /**
     * @param AdvanceGenerateDataKeyRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return AdvanceGenerateDataKeyResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        $generateDataKeyResponse = $this->client->advanceGenerateDataKeyWithOptions($dkmsRequest, $dkmsRuntimeOptions);

        $advanceEncryptRequest = new AdvanceEncryptRequest([
            "keyId" => $dkmsRequest->keyId,
            "plaintext" => base64_encode(AlibabaCloudTeaUtils::toString($generateDataKeyResponse->plaintext)),
            "aad" => $dkmsRequest->aad,
        ]);
        $advanceEncryptResponse = $this->client->advanceEncryptWithOptions($advanceEncryptRequest, $dkmsRuntimeOptions);

        $generateDataKeyResponse->ciphertextBlob = $advanceEncryptResponse->ciphertextBlob;
        $generateDataKeyResponse->iv = $advanceEncryptResponse->iv;
        return $generateDataKeyResponse;
    }

    /**
     * @param AdvanceGenerateDataKeyResponse $response
     * @param KmsRuntimeOptions $runtimeOptions
     * @return array
     */
    public function transferToOpenApiResponse($response, $runtimeOptions)
    {
        $offset = Constants::MAGIC_NUM_LENGTH + Constants::CIPHER_VER_AND_PADDING_MODE_LENGTH + Constants::ALGORITHM_LENGTH;
        $rawCiphertextBlob = array_slice($response->ciphertextBlob, $offset);
        $generateDataKeyWithoutPlaintextResponseBody = [
            "CiphertextBlob" => base64_encode(AlibabaCloudTeaUtils::toString($rawCiphertextBlob)),
            "KeyId" => $response->keyId,
            "KeyVersionId" => $response->keyVersionId,
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