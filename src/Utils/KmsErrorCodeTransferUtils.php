<?php

namespace AlibabaCloud\Kms\Kms20160120\Utils;

use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils;

class KmsErrorCodeTransferUtils
{
    const INVALID_PARAM_ERROR_CODE = "InvalidParam";
    const UNAUTHORIZED_ERROR_CODE = "Unauthorized";
    const MISSING_PARAMETER_ERROR_CODE = "MissingParameter";
    const INVALID_PARAMETER_ERROR_CODE = "InvalidParameter";
    const FORBIDDEN_KEY_NOT_FOUND_ERROR_CODE = "Forbidden.KeyNotFound";
    const INVALID_PARAMETER_KEY_SPEC_ERROR_MESSAGE = "The specified parameter KeySpec is not valid.";
    const INVALID_PARAM_DATE_ERROR_MESSAGE = "The Param Date is invalid.";
    const INVALID_PARAM_AUTHORIZATION_ERROR_MESSAGE = "The Param Authorization is invalid.";

    private static $errorCodeMap = [
        KmsErrorCodeTransferUtils::FORBIDDEN_KEY_NOT_FOUND_ERROR_CODE => "The specified Key is not found.",
        "Forbidden.NoPermission" => "This operation is forbidden by permission system.",
        "InternalFailure" => "Internal Failure",
        "Rejected.Throttling" => "QPS Limit Exceeded",
    ];

    public static function transferErrorMessage($errorCode)
    {
        if (array_key_exists($errorCode, self::$errorCodeMap))
            return self::$errorCodeMap[$errorCode];
        return "";
    }

    /**
     * @param TeaError $e
     * @return TeaError
     */
    public static function transferInvalidDateException($e)
    {
        $e->code = "IllegalTimestamp";
        $e->message = "The input parameter \"Timestamp\" that is mandatory for processing this request is not supplied.";
        $data = $e->getErrorInfo();
        if (!Utils::isUnset($data)) {
            $data["Code"] = $e->code;
            $data["Message"] = $e->message;
        }
        return new TeaError($data, $e->message, $e->code, $e);
    }

    /**
     * @param TeaError $e
     * @return TeaError
     */
    public static function transferInvalidAccessKeyIdException($e)
    {
        $e->code = "InvalidAccessKeyId.NotFound";
        $e->message = "The input parameter \"Timestamp\" that is mandatory for processing this request is not supplied.";
        $data = $e->getErrorInfo();
        if (!Utils::isUnset($data)) {
            $data["Code"] = $e->code;
            $data["Message"] = $e->message;
        }
        return new TeaError($data, $e->message, $e->code, $e);

    }

    /**
     * @param TeaError $e
     * @return TeaError
     */
    public static function transferIncompleteSignatureException($e)
    {
        $e->code = "IncompleteSignature";
        $e->message = "The request signature does not conform to Aliyun standards.";
        $data = $e->getErrorInfo();
        if (!Utils::isUnset($data)) {
            $data["Code"] = $e->code;
            $data["Message"] = $e->message;
        }
        return new TeaError($data, $e->message, $e->code, $e);
    }

}