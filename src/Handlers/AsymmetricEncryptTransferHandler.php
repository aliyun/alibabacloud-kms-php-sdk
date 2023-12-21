<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\EncryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\EncryptResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class AsymmetricEncryptTransferHandler extends KmsTransferHandler
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
     * @return EncryptRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        if (!array_key_exists("Plaintext", $query)) {
            throw $this->newMissingParameterClientException("Plaintext");
        }
        $asymmetricEncryptDKmsRequest = new EncryptRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "plaintext" => !empty(base64_decode($query["Plaintext"])) ? base64_decode($query["Plaintext"]) : null,
            "algorithm" => isset($query["Algorithm"]) ? $query["Algorithm"] : null,
        ]);
        $keyVersionId = isset($query["KeyVersionId"]) ? $query["KeyVersionId"] : null;
        if (!empty($keyVersionId)) {
            $asymmetricEncryptDKmsRequest->requestHeaders = [Constants::MIGRATION_KEY_VERSION_ID_KEY => $keyVersionId];
        }
        return $asymmetricEncryptDKmsRequest;
    }

    /**
     * @param EncryptRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return EncryptResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->encryptWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param EncryptResponse $response
     * @param KmsRuntimeOptions $runtimeOptions
     * @return array
     */
    public function transferToOpenApiResponse($response, $runtimeOptions)
    {
        $responseHeaders = $response->responseHeaders;
        $keyVersionId = null;
        if (!AlibabaCloudTeaUtils::isUnset($responseHeaders) && !empty($responseHeaders)) {
            $keyVersionId = $responseHeaders[Constants::MIGRATION_KEY_VERSION_ID_KEY];
        }
        $asymmetricEncryptResponseBody = [
            'CiphertextBlob' => base64_encode(AlibabaCloudTeaUtils::toString($response->ciphertextBlob)),
            'KeyId' => $response->keyId,
            'KeyVersionId' => $keyVersionId,
            'RequestId' => $response->requestId
        ];
        return [
            "body" => $asymmetricEncryptResponseBody,
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