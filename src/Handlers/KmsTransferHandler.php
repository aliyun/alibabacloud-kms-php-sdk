<?php

namespace AlibabaCloud\Kms\Kms20160120\Handlers;

use AlibabaCloud\Dkms\Gcs\OpenApi\Util\Models\RuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\Constants;
use AlibabaCloud\Kms\Kms20160120\Utils\KmsErrorCodeTransferUtils;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Exception;

abstract class KmsTransferHandler
{
    /**
     * @var array
     */
    public $responseHeaders = [Constants::MIGRATION_KEY_VERSION_ID_KEY];

    /**
     * @param $request
     * @param $runtimeOptions
     * @return mixed
     * @throws TeaError
     */
    abstract public function buildDKMSRequest($request, $runtimeOptions);

    /**
     * @param mixed $dkmsRequest
     * @param $runtimeOptions
     * @return mixed
     * @throws TeaError
     */
    abstract public function callDKMS($dkmsRequest, $runtimeOptions);

    /**
     * @param $response
     * @param $runtimeOptions
     * @return mixed
     * @throws TeaError
     */
    abstract public function transferToOpenApiResponse($response, $runtimeOptions);

    /**
     * @return mixed
     */
    abstract public function getClient();

    /**
     * @return string
     */
    abstract public function getAction();

    /**
     * @param TeaError $e
     * @return TeaError
     */
    public function transferTeaException($e)
    {
        switch ($e->code)
        {
            case KmsErrorCodeTransferUtils::INVALID_PARAM_ERROR_CODE:
                if (KmsErrorCodeTransferUtils::INVALID_PARAM_DATE_ERROR_MESSAGE == $e->message) {
                    return KmsErrorCodeTransferUtils::transferInvalidDateException($e);
                } else if (KmsErrorCodeTransferUtils::INVALID_PARAM_AUTHORIZATION_ERROR_MESSAGE == $e->message) {
                    return KmsErrorCodeTransferUtils::transferIncompleteSignatureException($e);
                }
                break;
            case KmsErrorCodeTransferUtils::UNAUTHORIZED_ERROR_CODE:
                return KmsErrorCodeTransferUtils::transferInvalidAccessKeyIdException($e);
            default:
                $errorMessage = KmsErrorCodeTransferUtils::transferErrorMessage($e->code);
                if (!empty($errorMessage)){
                    $e->message = $errorMessage;
                }
                $data = $e->getErrorInfo();
                if (!Utils::isUnset($data)) {
                    $data["Code"] = $e->code;
                    $data["Message"] = $e->message;
                }
                return new TeaError($data, $e->message, $e->code, $e);
        }
        return $e;
    }

    /**
     * @param OpenApiRequest $request
     * @param KmsRuntimeOptions $runtimeOptions
     * @return array
     * @throws TeaError
     */
    public function callApi($request, $runtimeOptions)
    {
        try {
            return $this->transferToOpenApiResponse($this->callDKMS($this->buildDKMSRequest($request, $runtimeOptions), $runtimeOptions), $runtimeOptions);
        }catch (TeaError $e) {
            throw $this->transferTeaException($e);
        }catch (Exception $e) {
            throw new TeaError([], $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $paramName
     * @return TeaError
     */
    public function newMissingParameterClientException($paramName)
    {
        return new TeaError([
            "code" => KmsErrorCodeTransferUtils::MISSING_PARAMETER_ERROR_CODE,
            "message" => "The parameter $paramName needed but no provided.",
        ]);
    }

    /**
     * @param string $paramName
     * @return TeaError
     */
    public function newInvalidParameterClientException($paramName)
    {
        return new TeaError([
            "code" => KmsErrorCodeTransferUtils::INVALID_PARAMETER_ERROR_CODE,
            "message" => "The parameter $paramName is invalid.",
        ]);
    }

    /**
     * @param KmsRuntimeOptions $runtimeOptions
     * @return RuntimeOptions
     */
    public function transferRuntimeOptions($runtimeOptions)
    {
        $dkmsRuntimeOptions = new RuntimeOptions();
        if (!Utils::isUnset($runtimeOptions)) {
            $dkmsRuntimeOptions->ignoreSSL = $runtimeOptions->ignoreSSL;
            $dkmsRuntimeOptions->autoretry = $runtimeOptions->autoretry;
            $dkmsRuntimeOptions->backoffPeriod = $runtimeOptions->backoffPeriod;
            $dkmsRuntimeOptions->backoffPolicy = $runtimeOptions->backoffPolicy;
            $dkmsRuntimeOptions->connectTimeout = $runtimeOptions->connectTimeout;
            $dkmsRuntimeOptions->httpProxy = $runtimeOptions->httpProxy;
            $dkmsRuntimeOptions->httpsProxy = $runtimeOptions->httpsProxy;
            $dkmsRuntimeOptions->maxAttempts = $runtimeOptions->maxAttempts;
            $dkmsRuntimeOptions->maxIdleConns = $runtimeOptions->maxIdleConns;
            $dkmsRuntimeOptions->noProxy = $runtimeOptions->noProxy;
            $dkmsRuntimeOptions->readTimeout = $runtimeOptions->readTimeout;
            $dkmsRuntimeOptions->socks5NetWork = $runtimeOptions->socks5NetWork;
            $dkmsRuntimeOptions->socks5Proxy = $runtimeOptions->socks5Proxy;
        }
        return $dkmsRuntimeOptions;
    }

}