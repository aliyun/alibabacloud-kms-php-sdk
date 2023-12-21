<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GetPublicKeyRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GetPublicKeyResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class GetPublicKeyTransferHandler extends KmsTransferHandler
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
     * @return GetPublicKeyRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        $getPublicKeyDKmsRequest = new GetPublicKeyRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
        ]);
        $keyVersionId = isset($query["KeyVersionId"]) ? $query["KeyVersionId"] : null;
        if (!empty($keyVersionId)) {
            $getPublicKeyDKmsRequest->requestHeaders = [Constants::MIGRATION_KEY_VERSION_ID_KEY => $keyVersionId];
        }
        return $getPublicKeyDKmsRequest;
    }

    /**
     * @param GetPublicKeyRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return GetPublicKeyResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->getPublicKeyWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param GetPublicKeyResponse $response
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
        $GetPublicKeyResponseBody = [
            "KeyId" => $response->keyId,
            "KeyVersionId" => $keyVersionId,
            "PublicKey" => $response->publicKey,
            "RequestId" => $response->requestId,
        ];
        return [
            "body" => $GetPublicKeyResponseBody,
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