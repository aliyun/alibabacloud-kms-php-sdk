<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\VerifyRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\VerifyResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class AsymmetricVerifyTransferHandler extends KmsTransferHandler
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
     * @return VerifyRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        if (!array_key_exists("Digest", $query)) {
            throw $this->newMissingParameterClientException("Digest");
        }
        if (!array_key_exists("Value", $query)) {
            throw $this->newMissingParameterClientException("Value");
        }
        $verifyDKmsRequest = new VerifyRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "signature" => base64_decode($query["Value"]),
            "algorithm" => isset($query["Algorithm"]) ? $query["Algorithm"] : null,
            "message" => base64_decode($query["Digest"]),
            "messageType" => Constants::DIGEST_MESSAGE_TYPE,
        ]);
        $keyVersionId = isset($query["KeyVersionId"]) ? $query["KeyVersionId"] : null;
        if (!empty($keyVersionId)) {
            $verifyDKmsRequest->requestHeaders = [Constants::MIGRATION_KEY_VERSION_ID_KEY => $keyVersionId];
        }
        return $verifyDKmsRequest;
    }

    /**
     * @param VerifyRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return VerifyResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->verifyWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param VerifyResponse $response
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
        $asymmetricVerifyResponseBody = [
            "KeyId" => $response->keyId,
            "KeyVersionId" => $keyVersionId,
            "RequestId" => $response->requestId,
            "Value" => $response->value,
        ];
        return [
            "body" => $asymmetricVerifyResponseBody,
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