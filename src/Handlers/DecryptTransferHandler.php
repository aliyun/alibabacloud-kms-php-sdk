<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\DecryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\DecryptResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\EncryptionContextUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class DecryptTransferHandler extends KmsTransferHandler
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

        $ciphertextBlob = base64_decode($query["CiphertextBlob"]);
        $ektIdBytes = substr($ciphertextBlob, 0, Constants::EKT_ID_LENGTH);
        $ivBytes = substr($ciphertextBlob, Constants::EKT_ID_LENGTH, Constants::GCM_IV_LENGTH);
        $rawCiphertextBytes = substr($ciphertextBlob, Constants::EKT_ID_LENGTH + Constants::GCM_IV_LENGTH);
        $ektId = $ektIdBytes;

        $decryptDKmsRequest = new DecryptRequest([
            "ciphertextBlob" => $rawCiphertextBytes,
            "iv" => $ivBytes,
        ]);

        if (array_key_exists("EncryptionContext", $query)) {
            $decryptDKmsRequest->aad = EncryptionContextUtils::encodeEncryptionContext($query["EncryptionContext"]);
        }

        $decryptDKmsRequest->requestHeaders = [Constants::MIGRATION_KEY_VERSION_ID_KEY => $ektId];
        return $decryptDKmsRequest;
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
        $decryptResponseBody = [
            "KeyId" => $response->keyId,
            "KeyVersionId" => $keyVersionId,
            "Plaintext" => AlibabaCloudTeaUtils::toString($response->plaintext),
            "RequestId" => $response->requestId,
        ];
        return [
            "body" => $decryptResponseBody,
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