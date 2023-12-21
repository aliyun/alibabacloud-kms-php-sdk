<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\Sdk\Client;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GetSecretValueRequest;
use AlibabaCloud\Dkms\Gcs\Sdk\Models\GetSecretValueResponse;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetSecretValueResponseBody;
use AlibabaCloud\Tea\Exception\TeaError;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

class GetSecretValueTransferHandler extends KmsTransferHandler
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
     * @return GetSecretValueRequest
     * @throws TeaError
     */
    public function buildDKMSRequest($request, $runtimeOptions)
    {
        $query = $request->query;
        return new GetSecretValueRequest([
            "secretName" => isset($query["SecretName"]) ? $query["SecretName"] : null,
            "versionStage" => isset($query["VersionStage"]) ? $query["VersionStage"] : null,
            "versionId" => isset($query["VersionId"]) ? $query["VersionId"] : null,
            "fetchExtendedConfig" => isset($query["FetchExtendedConfig"]) ? $query["FetchExtendedConfig"] : null,
        ]);
    }

    /**
     * @param GetSecretValueRequest $dkmsRequest
     * @param KmsRuntimeOptions $runtimeOptions
     * @return GetSecretValueResponse
     * @throws Exception
     */
    public function callDKMS($dkmsRequest, $runtimeOptions)
    {
        $dkmsRuntimeOptions = $this->transferRuntimeOptions($runtimeOptions);
        $dkmsRuntimeOptions->responseHeaders = $this->responseHeaders;
        return $this->client->getSecretValueWithOptions($dkmsRequest, $dkmsRuntimeOptions);
    }

    /**
     * @param GetSecretValueResponse $response
     * @param KmsRuntimeOptions $runtimeOptions
     * @return array
     */
    public function transferToOpenApiResponse($response, $runtimeOptions)
    {
        $getSecretValueResponseBody = [
            "AutomaticRotation" => $response->automaticRotation,
            "CreateTime" => $response->createTime,
            "ExtendedConfig" => $response->extendedConfig,
            "LastRotationDate" => $response->lastRotationDate,
            "NextRotationDate" => $response->nextRotationDate,
            "RequestId" => $response->requestId,
            "RotationInterval" => $response->rotationInterval,
            "SecretData" => $response->secretData,
            "SecretDataType" => $response->secretDataType,
            "SecretName" => $response->secretName,
            "SecretType" => $response->secretType,
            "VersionId" => $response->versionId,
            "VersionStages" => ["VersionStage" => $response->versionStages],
        ];
        return [
            "body" => $getSecretValueResponseBody,
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