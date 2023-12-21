<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceDecryptRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\AdvanceDecryptResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\EncryptionContextUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;


class AdvanceDecryptTransferHandler extends KmsTransferHandler
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
     * @return AdvanceDecryptRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        if (!array_key_exists("CiphertextBlob", $query)) {
            throw $this->newMissingParameterClientException("CiphertextBlob");
        }

        $ciphertextBlob = base64_decode($query["CiphertextBlob"]);
        $ivBytes = substr($ciphertextBlob, Constants::EKT_ID_LENGTH, Constants::EKT_ID_LENGTH + Constants::GCM_IV_LENGTH);
        $cipherVerAndPaddingMode = Constants::CIPHER_VER << 4 | 0;
        $cipherHeader = pack("CCC", ord(Constants::MAGIC_NUM), $cipherVerAndPaddingMode, Constants::ALG_AES_GCM);
        $dkmsCiphertextBlob = $cipherHeader . $ciphertextBlob;

        $advanceDecryptDKmsRequest = new AdvanceDecryptRequest([
            "iv" => $ivBytes,
            "ciphertextBlob" => $dkmsCiphertextBlob,
        ]);

        if (array_key_exists("EncryptionContext", $query)) {
            $advanceDecryptDKmsRequest->aad = EncryptionContextUtils::encodeEncryptionContext($query["EncryptionContext"]);
        }

        return $advanceDecryptDKmsRequest;
    }

    /**
     * @param AdvanceDecryptRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return AdvanceDecryptResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->advanceDecryptWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param AdvanceDecryptResponse $response
     * @param $runtimeOptions
     * @return array
     */
    public function transferToOpenApiResponse($response, $runtimeOptions)
    {
        $decryptResponseBody = [
            "KeyId" => $response->keyId,
            "KeyVersionId" => $response->keyVersionId,
            "RequestId" => $response->requestId,
            "Plaintext" => AlibabaCloudTeaUtils::toString($response->plaintext),
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