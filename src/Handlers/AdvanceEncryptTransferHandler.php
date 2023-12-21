<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceEncryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceEncryptResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\EncryptionContextUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class AdvanceEncryptTransferHandler extends KmsTransferHandler
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
     * @return AdvanceEncryptRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        if (!array_key_exists("Plaintext", $query)) {
            throw $this->newMissingParameterClientException("Plaintext");
        }
        $advanceEncryptDKmsRequest = new AdvanceEncryptRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "plaintext" => AlibabaCloudTeaUtils::toBytes($query["Plaintext"]),
        ]);
        if (array_key_exists("EncryptionContext", $query)) {
            $advanceEncryptDKmsRequest->aad = EncryptionContextUtils::encodeEncryptionContext($query["EncryptionContext"]);
        }
        return $advanceEncryptDKmsRequest;
    }

    /**
     * @param AdvanceEncryptRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return AdvanceEncryptResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->advanceEncryptWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param AdvanceEncryptResponse $response
     * @param $runtimeOptions
     * @return array
     */
    public function transferToOpenApiResponse($response, $runtimeOptions)
    {
        $offset = Constants::MAGIC_NUM_LENGTH + Constants::CIPHER_VER_AND_PADDING_MODE_LENGTH + Constants::ALGORITHM_LENGTH;
        $rawCiphertextBlob = array_slice($response->ciphertextBlob, $offset);
        $encryptResponseBody = [
            "KeyId" => $response->keyId,
            "KeyVersionId" => $response->keyVersionId,
            "RequestId" => $response->requestId,
            "CiphertextBlob" => base64_encode(AlibabaCloudTeaUtils::toString($rawCiphertextBlob))
        ];
        return [
            "body" => $encryptResponseBody,
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