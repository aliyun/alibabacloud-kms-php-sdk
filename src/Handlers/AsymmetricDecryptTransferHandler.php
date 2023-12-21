<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\DecryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\DecryptResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class AsymmetricDecryptTransferHandler extends KmsTransferHandler
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
     * @return DecryptRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        if (!array_key_exists("CiphertextBlob", $query)) {
            throw $this->newMissingParameterClientException("CiphertextBlob");
        }
        $asymmetricDecryptRequest = new DecryptRequest([
            "ciphertextBlob" => base64_decode($query["CiphertextBlob"]),
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "algorithm" => isset($query["Algorithm"]) ? $query["Algorithm"] : null,
        ]);
        $keyVersionId = isset($query["KeyVersionId"]) ? $query["KeyVersionId"] : null;
        if (!empty($keyVersionId)) {
            $asymmetricDecryptRequest->requestHeaders = [Constants::MIGRATION_KEY_VERSION_ID_KEY => $keyVersionId];
        }
        return $asymmetricDecryptRequest;
    }

    /**
     * @param DecryptRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return DecryptResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->decryptWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param DecryptResponse $response
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
        $asymmetricDecryptResponseBody = [
            "KeyId" => $response->keyId,
            "KeyVersionId" => $keyVersionId,
            "Plaintext" => base64_encode(AlibabaCloudTeaUtils::toString($response->plaintext)),
            "RequestId" => $response->requestId
        ];
        return [
            "body" => $asymmetricDecryptResponseBody,
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