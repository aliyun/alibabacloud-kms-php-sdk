<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\EncryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\EncryptResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\EncryptionContextUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class EncryptTransferHandler extends KmsTransferHandler
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
        $encryptDKmsRequest = new EncryptRequest([
            "keyId" => isset($query["KeyId"]) ? $query["KeyId"] : null,
            "plaintext" => AlibabaCloudTeaUtils::toBytes($query["Plaintext"]),
        ]);
        if (array_key_exists("EncryptionContext", $query)) {
            $encryptDKmsRequest->aad = EncryptionContextUtils::encodeEncryptionContext($query["EncryptionContext"]);
        }
        return $encryptDKmsRequest;
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
        $encryptResponseBody = [
            "CiphertextBlob" => base64_encode(AlibabaCloudTeaUtils::toString($ciphertextBlob)),
            "KeyId" => $response->keyId,
            "KeyVersionId" => $keyVersionId,
            "RequestId" => $response->requestId,
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