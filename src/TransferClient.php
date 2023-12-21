<?php

namespace AlibabaCloud\Kms\Kms20160120;

use AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config as DKmsConfig;
use AlibabaCloud\Dkms\Gcs\Sdk\Client as AlibabaCloudDkmsGcsSdkClient;
use AlibabaCloud\Kms\Kms20160120\Handlers\AdvanceDecryptTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AdvanceEncryptTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AdvanceGenerateDataKeyTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AdvanceGenerateDataKeyWithoutPlaintextTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AsymmetricDecryptTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AsymmetricEncryptTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AsymmetricSignTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\AsymmetricVerifyTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\DecryptTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\EncryptTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\GenerateDataKeyTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\GenerateDataKeyWithoutPlaintextTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\GetPublicKeyTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Handlers\GetSecretValueTransferHandler;
use AlibabaCloud\Kms\Kms20160120\Models\KmsConfig;
use AlibabaCloud\Kms\Kms20160120\Models\KmsRuntimeOptions;
use AlibabaCloud\Kms\Kms20160120\Utils\ApiNames;
use AlibabaCloud\SDK\Kms\V20160120\Kms;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricDecryptRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricDecryptResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricEncryptRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricEncryptResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricSignRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricSignResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricVerifyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\AsymmetricVerifyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DecryptRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DecryptResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\EncryptRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\EncryptResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateDataKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateDataKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateDataKeyWithoutPlaintextRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateDataKeyWithoutPlaintextResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetPublicKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetPublicKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetSecretValueRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetSecretValueResponse;
use AlibabaCloud\Tea\Exception\TeaError;
use AlibabaCloud\Tea\Utils\Utils as AlibabaCloudTeaUtils;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Darabonba\OpenApi\Models\Config;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Darabonba\OpenApi\Models\Params;


class TransferClient extends Kms
{
    /**
     * @var array
     */
    public $handlerMap;

    /**
     * @var AlibabaCloudDkmsGcsSdkClient
     */
    public $dkmsClient;

    /**
     * @var DKmsConfig|KmsConfig
     */
    public $kmsConfig;

    /**
     * 针对所有接口使用KMS共享网关开关 true:使用KMS共享网关 false:使用KMS实例网关
     * @var bool
     */
    public $isUseKmsShareGateway;

    /**
     * @param Config $config
     * @param DKmsConfig|KmsConfig $kmsConfig
     * @param bool $isUseKmsShareGateway
     */
    public function __construct($config, $kmsConfig, $isUseKmsShareGateway = false)
    {
        if (AlibabaCloudTeaUtils::isUnset($config) && AlibabaCloudTeaUtils::isUnset($kmsConfig)) {
            throw new TeaError([
                "message" => "The parameter config and kmsConfig can not be both None.",
            ]);
        }
        $this->isUseKmsShareGateway = $isUseKmsShareGateway;
        if (AlibabaCloudTeaUtils::isUnset($config)) {
            $config = new Config(["endpoint" => $kmsConfig->endpoint]);
            $this->isUseKmsShareGateway = false;
        }
        parent::__construct($config);
        if (AlibabaCloudTeaUtils::isUnset($kmsConfig)) {
            $this->isUseKmsShareGateway = true;
        } else {
            if (empty($kmsConfig->userAgent))
                $kmsConfig->userAgent = \AlibabaCloud\Kms\Kms20160120\Utils\Constants::TRANSFER_CLIENT_USER_AGENT;
            if ($kmsConfig instanceof KmsConfig) {
                $this->kmsConfig = $kmsConfig;
            }
            $this->dkmsClient = new AlibabaCloudDkmsGcsSdkClient($kmsConfig);
            $this->initKmsTransferHandler();
        }
    }

    private function initKmsTransferHandler()
    {
        $this->handlerMap[ApiNames::ASYMMETRIC_DECRYPT_API_NAME] = new AsymmetricDecryptTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::ASYMMETRIC_DECRYPT_API_NAME);
        $this->handlerMap[ApiNames::ASYMMETRIC_ENCRYPT_API_NAME] = new AsymmetricEncryptTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::ASYMMETRIC_DECRYPT_API_NAME);
        $this->handlerMap[ApiNames::ASYMMETRIC_SIGN_API_NAME] = new AsymmetricSignTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::ASYMMETRIC_SIGN_API_NAME);
        $this->handlerMap[ApiNames::ASYMMETRIC_VERIFY_API_NAME] = new AsymmetricVerifyTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::ASYMMETRIC_VERIFY_API_NAME);
        $this->handlerMap[ApiNames::GET_PUBLIC_KEY_API_NAME] = new GetPublicKeyTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::GET_PUBLIC_KEY_API_NAME);
        $this->handlerMap[ApiNames::GET_SECRET_VALUE_API_NAME] = new GetSecretValueTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::GET_SECRET_VALUE_API_NAME);
        if (!AlibabaCloudTeaUtils::isUnset($this->kmsConfig) && $this->kmsConfig->forceLowVersionCryptoTransfer) {
            $this->handlerMap[ApiNames::ENCRYPT_API_NAME] = new EncryptTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::ENCRYPT_API_NAME);
            $this->handlerMap[ApiNames::DECRYPT_API_NAME] = new DecryptTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::DECRYPT_API_NAME);
            $this->handlerMap[ApiNames::GENERATE_DATA_KEY_API_NAME] = new GenerateDataKeyTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::GENERATE_DATA_KEY_API_NAME);
            $this->handlerMap[ApiNames::GENERATE_DATA_KEY_WITHOUT_PLAINTEXT_API_NAME] = new GenerateDataKeyWithoutPlaintextTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::GENERATE_DATA_KEY_WITHOUT_PLAINTEXT_API_NAME);
        } else {
            $this->handlerMap[ApiNames::ENCRYPT_API_NAME] = new AdvanceEncryptTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::ENCRYPT_API_NAME);
            $this->handlerMap[ApiNames::DECRYPT_API_NAME] = new AdvanceDecryptTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::DECRYPT_API_NAME);
            $this->handlerMap[ApiNames::GENERATE_DATA_KEY_API_NAME] = new AdvanceGenerateDataKeyTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::GENERATE_DATA_KEY_API_NAME);
            $this->handlerMap[ApiNames::GENERATE_DATA_KEY_WITHOUT_PLAINTEXT_API_NAME] = new AdvanceGenerateDataKeyWithoutPlaintextTransferHandler($this->dkmsClient, $this->kmsConfig, ApiNames::GENERATE_DATA_KEY_WITHOUT_PLAINTEXT_API_NAME);
        }
    }

    /**
     * @param Params $params
     * @param OpenApiRequest $request
     * @param RuntimeOptions $runtime
     * @return array
     * @throws TeaError
     */
    public function callApi($params, $request, $runtime)
    {
        $action = $params->action;
        if ($runtime instanceof KmsRuntimeOptions) {
            $runtimeOptions = $runtime;
        } else {
            $runtimeOptions = new KmsRuntimeOptions($runtime);
        }
        if ($this->isUseKmsShareGateway($action, $runtimeOptions)) {
            return parent::callApi($params, $request, $runtimeOptions);
        }
        if (!AlibabaCloudTeaUtils::isUnset($this->kmsConfig) && !$this->kmsConfig->ignoreSSLVerifySwitch) {
            $runtimeOptions->ignoreSSL = false;
        }
        if (array_key_exists($action, $this->handlerMap)) {
            return $this->handlerMap[$action]->callApi($request, $runtimeOptions);
        }
        return parent::callApi($params, $request, $runtime);
    }

    /**
     * @param string $action
     * @param KmsRuntimeOptions $runtimeOptions
     * @return bool
     */
    private function isUseKmsShareGateway($action, $runtimeOptions)
    {
        if (!AlibabaCloudTeaUtils::isUnset($runtimeOptions->isUseKmsShareGateway)) {
            return $runtimeOptions->isUseKmsShareGateway;
        }
        if (!AlibabaCloudTeaUtils::isUnset($this->kmsConfig) && !AlibabaCloudTeaUtils::isUnset($this->kmsConfig->defaultKmsApiNames)
            && in_array($action, $this->kmsConfig->defaultKmsApiNames)) {
            return true;
        }
        return $this->isUseKmsShareGateway;
    }

    /**
     * @param AsymmetricDecryptRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return AsymmetricDecryptResponse
     */
    public function asymmetricDecryptWithOptions($request, $runtime)
    {
        return parent::asymmetricDecryptWithOptions($request, $runtime);
    }

    /**
     * @param AsymmetricDecryptRequest $request
     * @return AsymmetricDecryptResponse
     */
    public function asymmetricDecrypt($request)
    {
        return $this->asymmetricDecryptWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param AsymmetricEncryptRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return AsymmetricEncryptResponse
     */
    public function asymmetricEncryptWithOptions($request, $runtime)
    {
        return parent::asymmetricEncryptWithOptions($request, $runtime);
    }

    /**
     * @param AsymmetricEncryptRequest $request
     * @return AsymmetricEncryptResponse
     */
    public function asymmetricEncrypt($request)
    {
        return $this->asymmetricEncryptWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param AsymmetricSignRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return AsymmetricSignResponse
     */
    public function asymmetricSignWithOptions($request, $runtime)
    {
        return parent::asymmetricSignWithOptions($request, $runtime);
    }

    /**
     * @param AsymmetricSignRequest $request
     * @return AsymmetricSignResponse
     */
    public function asymmetricSign($request)
    {
        return $this->asymmetricSignWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param AsymmetricVerifyRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return AsymmetricVerifyResponse
     */
    public function asymmetricVerifyWithOptions($request, $runtime)
    {
        return parent::asymmetricVerifyWithOptions($request, $runtime);
    }

    /**
     * @param AsymmetricVerifyRequest $request
     * @return AsymmetricVerifyResponse
     */
    public function asymmetricVerify($request)
    {
        return $this->asymmetricVerifyWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param DecryptRequest $request
     * @return DecryptResponse
     */
    public function decrypt($request)
    {
        return $this->decryptWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param DecryptRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return DecryptResponse
     */
    public function decryptWithOptions($request, $runtime)
    {
        return parent::decryptWithOptions($request, $runtime);
    }

    /**
     * @param EncryptRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return EncryptResponse
     */
    public function encryptWithOptions($request, $runtime)
    {
        return parent::encryptWithOptions($request, $runtime);
    }

    /**
     * @param EncryptRequest $request
     * @return EncryptResponse
     */
    public function encrypt($request)
    {
        return $this->encryptWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param GenerateDataKeyRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return GenerateDataKeyResponse
     */
    public function generateDataKeyWithOptions($request, $runtime)
    {
        return parent::generateDataKeyWithOptions($request, $runtime);
    }

    /**
     * @param GenerateDataKeyRequest $request
     * @return GenerateDataKeyResponse
     */
    public function generateDataKey($request)
    {
        return $this->generateDataKeyWithOptions($request, new KmsRuntimeOptions([]));
    }

    /**
     * @param GenerateDataKeyWithoutPlaintextRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return GenerateDataKeyWithoutPlaintextResponse
     */
    public function generateDataKeyWithoutPlaintextWithOptions($request, $runtime)
    {
        return parent::generateDataKeyWithoutPlaintextWithOptions($request, $runtime);
    }

    /**
     * @param GenerateDataKeyWithoutPlaintextRequest $request
     * @return GenerateDataKeyWithoutPlaintextResponse
     */
    public function generateDataKeyWithoutPlaintext($request)
    {
        return parent::generateDataKeyWithoutPlaintextWithOptions($request, new KmsRuntimeOptions());
    }

    /**
     * @param GetPublicKeyRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return GetPublicKeyResponse
     */
    public function getPublicKeyWithOptions($request, $runtime)
    {
        return parent::getPublicKeyWithOptions($request, $runtime);
    }

    /**
     * @param GetPublicKeyRequest $request
     * @return GetPublicKeyResponse
     */
    public function getPublicKey($request)
    {
        return $this->getPublicKeyWithOptions($request, new KmsRuntimeOptions());
    }

    /**
     * @param GetSecretValueRequest $request
     * @param RuntimeOptions|KmsRuntimeOptions $runtime
     * @return GetSecretValueResponse
     */
    public
    function getSecretValueWithOptions($request, $runtime)
    {
        return parent::getSecretValueWithOptions($request, $runtime);
    }

    /**
     * @param GetSecretValueRequest $request
     * @return GetSecretValueResponse
     */
    public
    function getSecretValue($request)
    {
        return $this->getSecretValueWithOptions($request, new KmsRuntimeOptions());
    }


}