<?php

// This file is auto-generated, don't edit it. Thanks.
namespace AlibabaCloud\Kms\Kms20160120;

use AlibabaCloud\Dkms\Gcs\Sdk\Client as AlibabaCloudDkmsGcsSdkClient;
use AlibabaCloud\SDK\Kms\V20160120\Kms;
use AlibabaCloud\OpenApiUtil\OpenApiUtilClient;

use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Darabonba\OpenApi\Models\OpenApiRequest;
use Darabonba\OpenApi\Models\Params;
use AlibabaCloud\SDK\Kms\V20160120\Models\CancelKeyDeletionRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\CancelKeyDeletionResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateAliasRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateAliasResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateKeyVersionRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateKeyVersionResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateSecretRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\CreateSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteAliasRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteAliasResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteKeyMaterialRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteKeyMaterialResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteSecretRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DeleteSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeKeyVersionRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeKeyVersionResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeSecretRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DisableKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\DisableKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\EnableKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\EnableKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ExportDataKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ExportDataKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateAndExportDataKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GenerateAndExportDataKeyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetParametersForImportRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetParametersForImportResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetRandomPasswordRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetRandomPasswordResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ImportKeyMaterialRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ImportKeyMaterialResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListAliasesRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListAliasesResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListKeysRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListKeysResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListKeyVersionsRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListKeyVersionsResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListResourceTagsRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListResourceTagsResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListSecretsRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListSecretsResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListSecretVersionIdsRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ListSecretVersionIdsResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\PutSecretValueRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\PutSecretValueResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\RestoreSecretRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\RestoreSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\RotateSecretRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\RotateSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\ScheduleKeyDeletionRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\ScheduleKeyDeletionResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\SetDeletionProtectionRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\SetDeletionProtectionResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\TagResourceRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\TagResourceResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UntagResourceRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UntagResourceResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateAliasRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateAliasResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateKeyDescriptionRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateKeyDescriptionResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateRotationPolicyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateRotationPolicyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateSecretRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateSecretResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateSecretRotationPolicyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateSecretRotationPolicyResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateSecretVersionStageRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\UpdateSecretVersionStageResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\OpenKmsServiceResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeRegionsResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\DescribeAccountKmsStatusResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetSecretValueRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetSecretValueResponse;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetPublicKeyRequest;
use AlibabaCloud\SDK\Kms\V20160120\Models\GetPublicKeyResponse;

class Client extends AlibabaCloudDkmsGcsSdkClient {
    protected $_kmsClient;

    public function __construct($kmsInstanceConfig, $openApiConfig){
        if (!isset($kmsInstanceConfig) || $kmsInstanceConfig == null)
            $kmsInstanceConfig = new \AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config(["endpoint" => "mock endpoint"]);
        if (empty($kmsInstanceConfig->userAgent))
            $kmsInstanceConfig->userAgent = \AlibabaCloud\Kms\Kms20160120\Utils\Constants::CLIENT_USER_AGENT;
        parent::__construct($kmsInstanceConfig);
        if (!isset($openApiConfig) || $openApiConfig == null)
            $openApiConfig = new \Darabonba\OpenApi\Models\Config(["regionId" => "mock regionId"]);
        $this->_kmsClient = new Kms($openApiConfig);
    }

    /**
     * @param mixed[] $query
     * @param string $action
     * @param RuntimeOptions $runtime
     * @return array
     */
    public function doAction($query, $action, $runtime){
        $req = new OpenApiRequest([
            "query" => OpenApiUtilClient::query($query)
        ]);
        $params = new Params([
            "action" => $action,
            "version" => "2016-01-20",
            "protocol" => "HTTPS",
            "pathname" => "/",
            "method" => "POST",
            "authType" => "AK",
            "style" => "RPC",
            "reqBodyType" => "formData",
            "bodyType" => "json"
        ]);
        return $this->_kmsClient->callApi($params, $req, $runtime);
    }

    /**
     * 调用CancelKeyDeletion接口撤销密钥删除

     * @param CancelKeyDeletionRequest $request
     * @return CancelKeyDeletionResponse CancelKeyDeletionResponse
     */
    public function cancelKeyDeletion($request){
        return $this->_kmsClient->cancelKeyDeletion($request);
    }

    /**
     * 带运行参数调用CancelKeyDeletion接口撤销密钥删除

     * @param CancelKeyDeletionRequest $request
     * @param RuntimeOptions $runtime
     * @return CancelKeyDeletionResponse CancelKeyDeletionResponse
     */
    public function cancelKeyDeletionWithOptions($request, $runtime){
        return $this->_kmsClient->cancelKeyDeletionWithOptions($request, $runtime);
    }

    /**
     * 调用CreateAlias接口为主密钥（CMK）创建一个别名

     * @param CreateAliasRequest $request
     * @return CreateAliasResponse CreateAliasResponse
     */
    public function createAlias($request){
        return $this->_kmsClient->createAlias($request);
    }

    /**
     * 带运行参数调用CreateAlias接口为主密钥（CMK）创建一个别名

     * @param CreateAliasRequest $request
     * @param RuntimeOptions $runtime
     * @return CreateAliasResponse CreateAliasResponse
     */
    public function createAliasWithOptions($request, $runtime){
        return $this->_kmsClient->createAliasWithOptions($request, $runtime);
    }

    /**
     * 调用CreateKey接口创建一个主密钥

     * @param CreateKeyRequest $request
     * @return CreateKeyResponse CreateKeyResponse
     */
    public function createKey($request){
        return $this->_kmsClient->createKey($request);
    }

    /**
     * 带运行参数调用CreateKey接口创建一个主密钥

     * @param CreateKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return CreateKeyResponse CreateKeyResponse
     */
    public function createKeyWithOptions($request, $runtime){
        return $this->_kmsClient->createKeyWithOptions($request, $runtime);
    }

    /**
     * 调用CreateKeyVersion接口为用户主密钥（CMK）创建密钥版本

     * @param CreateKeyVersionRequest $request
     * @return CreateKeyVersionResponse CreateKeyVersionResponse
     */
    public function createKeyVersion($request){
        return $this->_kmsClient->createKeyVersion($request);
    }

    /**
     * 带运行参数调用CreateKeyVersion接口为用户主密钥（CMK）创建密钥版本

     * @param CreateKeyVersionRequest $request
     * @param RuntimeOptions $runtime
     * @return CreateKeyVersionResponse CreateKeyVersionResponse
     */
    public function createKeyVersionWithOptions($request, $runtime){
        return $this->_kmsClient->createKeyVersionWithOptions($request, $runtime);
    }

    /**
     * 创建凭据并存入凭据的初始版本

     * @param CreateSecretRequest $request
     * @return CreateSecretResponse CreateSecretResponse
     */
    public function createSecret($request){
        return $this->_kmsClient->createSecret($request);
    }

    /**
     * 带运行参数创建凭据并存入凭据的初始版本

     * @param CreateSecretRequest $request
     * @param RuntimeOptions $runtime
     * @return CreateSecretResponse CreateSecretResponse
     */
    public function createSecretWithOptions($request, $runtime){
        return $this->_kmsClient->createSecretWithOptions($request, $runtime);
    }

    /**
     * 调用DeleteAlias接口删除别名

     * @param DeleteAliasRequest $request
     * @return DeleteAliasResponse DeleteAliasResponse
     */
    public function deleteAlias($request){
        return $this->_kmsClient->deleteAlias($request);
    }

    /**
     * 带运行参数调用DeleteAlias接口删除别名

     * @param DeleteAliasRequest $request
     * @param RuntimeOptions $runtime
     * @return DeleteAliasResponse DeleteAliasResponse
     */
    public function deleteAliasWithOptions($request, $runtime){
        return $this->_kmsClient->deleteAliasWithOptions($request, $runtime);
    }

    /**
     * 调用DeleteKeyMaterial接口删除已导入的密钥材料

     * @param DeleteKeyMaterialRequest $request
     * @return DeleteKeyMaterialResponse DeleteKeyMaterialResponse
     */
    public function deleteKeyMaterial($request){
        return $this->_kmsClient->deleteKeyMaterial($request);
    }

    /**
     * 带运行参数调用DeleteKeyMaterial接口删除已导入的密钥材料

     * @param DeleteKeyMaterialRequest $request
     * @param RuntimeOptions $runtime
     * @return DeleteKeyMaterialResponse DeleteKeyMaterialResponse
     */
    public function deleteKeyMaterialWithOptions($request, $runtime){
        return $this->_kmsClient->deleteKeyMaterialWithOptions($request, $runtime);
    }

    /**
     * 调用DeleteSecret接口删除凭据对象

     * @param DeleteSecretRequest $request
     * @return DeleteSecretResponse DeleteSecretResponse
     */
    public function deleteSecret($request){
        return $this->_kmsClient->deleteSecret($request);
    }

    /**
     * 带运行参数调用DeleteSecret接口删除凭据对象

     * @param DeleteSecretRequest $request
     * @param RuntimeOptions $runtime
     * @return DeleteSecretResponse DeleteSecretResponse
     */
    public function deleteSecretWithOptions($request, $runtime){
        return $this->_kmsClient->deleteSecretWithOptions($request, $runtime);
    }

    /**
     * 调用DescribeKey接口查询用户主密钥（CMK）详情

     * @param DescribeKeyRequest $request
     * @return DescribeKeyResponse DescribeKeyResponse
     */
    public function describeKey($request){
        return $this->_kmsClient->describeKey($request);
    }

    /**
     * 带运行参数调用DescribeKey接口查询用户主密钥（CMK）详情

     * @param DescribeKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return DescribeKeyResponse DescribeKeyResponse
     */
    public function describeKeyWithOptions($request, $runtime){
        return $this->_kmsClient->describeKeyWithOptions($request, $runtime);
    }

    /**
     * 调用DescribeKeyVersion接口查询指定密钥版本信息

     * @param DescribeKeyVersionRequest $request
     * @return DescribeKeyVersionResponse DescribeKeyVersionResponse
     */
    public function describeKeyVersion($request){
        return $this->_kmsClient->describeKeyVersion($request);
    }

    /**
     * 带运行参数调用DescribeKeyVersion接口查询指定密钥版本信息

     * @param DescribeKeyVersionRequest $request
     * @param RuntimeOptions $runtime
     * @return DescribeKeyVersionResponse DescribeKeyVersionResponse
     */
    public function describeKeyVersionWithOptions($request, $runtime){
        return $this->_kmsClient->describeKeyVersionWithOptions($request, $runtime);
    }

    /**
     * 调用DescribeSecret接口查询凭据的元数据信息

     * @param DescribeSecretRequest $request
     * @return DescribeSecretResponse DescribeSecretResponse
     */
    public function describeSecret($request){
        return $this->_kmsClient->describeSecret($request);
    }

    /**
     * 带运行参数调用DescribeSecret接口查询凭据的元数据信息

     * @param DescribeSecretRequest $request
     * @param RuntimeOptions $runtime
     * @return DescribeSecretResponse DescribeSecretResponse
     */
    public function describeSecretWithOptions($request, $runtime){
        return $this->_kmsClient->describeSecretWithOptions($request, $runtime);
    }

    /**
     * 调用DisableKey接口禁用指定的主密钥（CMK）进行加解密

     * @param DisableKeyRequest $request
     * @return DisableKeyResponse DisableKeyResponse
     */
    public function disableKey($request){
        return $this->_kmsClient->disableKey($request);
    }

    /**
     * 带运行参数调用DisableKey接口禁用指定的主密钥（CMK）进行加解密

     * @param DisableKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return DisableKeyResponse DisableKeyResponse
     */
    public function disableKeyWithOptions($request, $runtime){
        return $this->_kmsClient->disableKeyWithOptions($request, $runtime);
    }

    /**
     * 调用EnableKey接口启用指定的主密钥进行加解密

     * @param EnableKeyRequest $request
     * @return EnableKeyResponse EnableKeyResponse
     */
    public function enableKey($request){
        return $this->_kmsClient->enableKey($request);
    }

    /**
     * 带运行参数调用EnableKey接口启用指定的主密钥进行加解密

     * @param EnableKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return EnableKeyResponse EnableKeyResponse
     */
    public function enableKeyWithOptions($request, $runtime){
        return $this->_kmsClient->enableKeyWithOptions($request, $runtime);
    }

    /**
     * 调用ExportDataKey接口使用传入的公钥加密导出数据密钥

     * @param ExportDataKeyRequest $request
     * @return ExportDataKeyResponse ExportDataKeyResponse
     */
    public function exportDataKey($request){
        return $this->_kmsClient->exportDataKey($request);
    }

    /**
     * 带运行参数调用ExportDataKey接口使用传入的公钥加密导出数据密钥

     * @param ExportDataKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return ExportDataKeyResponse ExportDataKeyResponse
     */
    public function exportDataKeyWithOptions($request, $runtime){
        return $this->_kmsClient->exportDataKeyWithOptions($request, $runtime);
    }

    /**
     * 调用GenerateAndExportDataKey接口随机生成一个数据密钥

     * @param GenerateAndExportDataKeyRequest $request
     * @return GenerateAndExportDataKeyResponse GenerateAndExportDataKeyResponse
     */
    public function generateAndExportDataKey($request){
        return $this->_kmsClient->generateAndExportDataKey($request);
    }

    /**
     * 带运行参数调用GenerateAndExportDataKey接口随机生成一个数据密钥

     * @param GenerateAndExportDataKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return GenerateAndExportDataKeyResponse GenerateAndExportDataKeyResponse
     */
    public function generateAndExportDataKeyWithOptions($request, $runtime){
        return $this->_kmsClient->generateAndExportDataKeyWithOptions($request, $runtime);
    }

    /**
     * 调用GetParametersForImport接口获取导入主密钥材料的参数

     * @param GetParametersForImportRequest $request
     * @return GetParametersForImportResponse GetParametersForImportResponse
     */
    public function getParametersForImport($request){
        return $this->_kmsClient->getParametersForImport($request);
    }

    /**
     * 带运行参数调用GetParametersForImport接口获取导入主密钥材料的参数

     * @param GetParametersForImportRequest $request
     * @param RuntimeOptions $runtime
     * @return GetParametersForImportResponse GetParametersForImportResponse
     */
    public function getParametersForImportWithOptions($request, $runtime){
        return $this->_kmsClient->getParametersForImportWithOptions($request, $runtime);
    }

    /**
     * 调用GetRandomPassword接口获得一个随机口令字符串

     * @param GetRandomPasswordRequest $request
     * @return GetRandomPasswordResponse GetRandomPasswordResponse
     */
    public function getRandomPassword($request){
        return $this->_kmsClient->getRandomPassword($request);
    }

    /**
     * 带运行参数调用GetRandomPassword接口获得一个随机口令字符串

     * @param GetRandomPasswordRequest $request
     * @param RuntimeOptions $runtime
     * @return GetRandomPasswordResponse GetRandomPasswordResponse
     */
    public function getRandomPasswordWithOptions($request, $runtime){
        return $this->_kmsClient->getRandomPasswordWithOptions($request, $runtime);
    }

    /**
     * 调用ImportKeyMaterial接口导入密钥材料

     * @param ImportKeyMaterialRequest $request
     * @return ImportKeyMaterialResponse ImportKeyMaterialResponse
     */
    public function importKeyMaterial($request){
        return $this->_kmsClient->importKeyMaterial($request);
    }

    /**
     * 带运行参数调用ImportKeyMaterial接口导入密钥材料

     * @param ImportKeyMaterialRequest $request
     * @param RuntimeOptions $runtime
     * @return ImportKeyMaterialResponse ImportKeyMaterialResponse
     */
    public function importKeyMaterialWithOptions($request, $runtime){
        return $this->_kmsClient->importKeyMaterialWithOptions($request, $runtime);
    }

    /**
     * 调用ListAliases接口查询当前用户在当前地域的所有别名

     * @param ListAliasesRequest $request
     * @return ListAliasesResponse ListAliasesResponse
     */
    public function listAliases($request){
        return $this->_kmsClient->listAliases($request);
    }

    /**
     * 带运行参数调用ListAliases接口查询当前用户在当前地域的所有别名

     * @param ListAliasesRequest $request
     * @param RuntimeOptions $runtime
     * @return ListAliasesResponse ListAliasesResponse
     */
    public function listAliasesWithOptions($request, $runtime){
        return $this->_kmsClient->listAliasesWithOptions($request, $runtime);
    }

    /**
     * 调用ListKeys查询调用者在调用地域的所有主密钥ID

     * @param ListKeysRequest $request
     * @return ListKeysResponse ListKeysResponse
     */
    public function listKeys($request){
        return $this->_kmsClient->listKeys($request);
    }

    /**
     * 带运行参数调用ListKeys查询调用者在调用地域的所有主密钥ID

     * @param ListKeysRequest $request
     * @param RuntimeOptions $runtime
     * @return ListKeysResponse ListKeysResponse
     */
    public function listKeysWithOptions($request, $runtime){
        return $this->_kmsClient->listKeysWithOptions($request, $runtime);
    }

    /**
     * 调用ListKeyVersions接口列出主密钥的所有密钥版本

     * @param ListKeyVersionsRequest $request
     * @return ListKeyVersionsResponse ListKeyVersionsResponse
     */
    public function listKeyVersions($request){
        return $this->_kmsClient->listKeyVersions($request);
    }

    /**
     * 带运行参数调用ListKeyVersions接口列出主密钥的所有密钥版本

     * @param ListKeyVersionsRequest $request
     * @param RuntimeOptions $runtime
     * @return ListKeyVersionsResponse ListKeyVersionsResponse
     */
    public function listKeyVersionsWithOptions($request, $runtime){
        return $this->_kmsClient->listKeyVersionsWithOptions($request, $runtime);
    }

    /**
     * 调用ListResourceTags获取用户主密钥的标签

     * @param ListResourceTagsRequest $request
     * @return ListResourceTagsResponse ListResourceTagsResponse
     */
    public function listResourceTags($request){
        return $this->_kmsClient->listResourceTags($request);
    }

    /**
     * 带运行参数调用ListResourceTags获取用户主密钥的标签

     * @param ListResourceTagsRequest $request
     * @param RuntimeOptions $runtime
     * @return ListResourceTagsResponse ListResourceTagsResponse
     */
    public function listResourceTagsWithOptions($request, $runtime){
        return $this->_kmsClient->listResourceTagsWithOptions($request, $runtime);
    }

    /**
     * 调用ListSecrets接口查询当前用户在当前地域创建的所有凭据

     * @param ListSecretsRequest $request
     * @return ListSecretsResponse ListSecretsResponse
     */
    public function listSecrets($request){
        return $this->_kmsClient->listSecrets($request);
    }

    /**
     * 带运行参数调用ListSecrets接口查询当前用户在当前地域创建的所有凭据

     * @param ListSecretsRequest $request
     * @param RuntimeOptions $runtime
     * @return ListSecretsResponse ListSecretsResponse
     */
    public function listSecretsWithOptions($request, $runtime){
        return $this->_kmsClient->listSecretsWithOptions($request, $runtime);
    }

    /**
     * 调用ListSecretVersionIds接口查询凭据的所有版本信息

     * @param ListSecretVersionIdsRequest $request
     * @return ListSecretVersionIdsResponse ListSecretVersionIdsResponse
     */
    public function listSecretVersionIds($request){
        return $this->_kmsClient->listSecretVersionIds($request);
    }

    /**
     * 带运行参数调用ListSecretVersionIds接口查询凭据的所有版本信息

     * @param ListSecretVersionIdsRequest $request
     * @param RuntimeOptions $runtime
     * @return ListSecretVersionIdsResponse ListSecretVersionIdsResponse
     */
    public function listSecretVersionIdsWithOptions($request, $runtime){
        return $this->_kmsClient->listSecretVersionIdsWithOptions($request, $runtime);
    }

    /**
     * 调用PutSecretValue接口为凭据存入一个新版本的凭据值

     * @param PutSecretValueRequest $request
     * @return PutSecretValueResponse PutSecretValueResponse
     */
    public function putSecretValue($request){
        return $this->_kmsClient->putSecretValue($request);
    }

    /**
     * 带运行参数调用PutSecretValue接口为凭据存入一个新版本的凭据值

     * @param PutSecretValueRequest $request
     * @param RuntimeOptions $runtime
     * @return PutSecretValueResponse PutSecretValueResponse
     */
    public function putSecretValueWithOptions($request, $runtime){
        return $this->_kmsClient->putSecretValueWithOptions($request, $runtime);
    }

    /**
     * 调用RestoreSecret接口恢复被删除的凭据

     * @param RestoreSecretRequest $request
     * @return RestoreSecretResponse RestoreSecretResponse
     */
    public function restoreSecret($request){
        return $this->_kmsClient->restoreSecret($request);
    }

    /**
     * 带运行参数调用RestoreSecret接口恢复被删除的凭据

     * @param RestoreSecretRequest $request
     * @param RuntimeOptions $runtime
     * @return RestoreSecretResponse RestoreSecretResponse
     */
    public function restoreSecretWithOptions($request, $runtime){
        return $this->_kmsClient->restoreSecretWithOptions($request, $runtime);
    }

    /**
     * 调用RotateSecret接口手动轮转凭据

     * @param RotateSecretRequest $request
     * @return RotateSecretResponse RotateSecretResponse
     */
    public function rotateSecret($request){
        return $this->_kmsClient->rotateSecret($request);
    }

    /**
     * 带运行参数调用RotateSecret接口手动轮转凭据

     * @param RotateSecretRequest $request
     * @param RuntimeOptions $runtime
     * @return RotateSecretResponse RotateSecretResponse
     */
    public function rotateSecretWithOptions($request, $runtime){
        return $this->_kmsClient->rotateSecretWithOptions($request, $runtime);
    }

    /**
     * 调用ScheduleKeyDeletion接口申请删除一个指定的主密钥（CMK)

     * @param ScheduleKeyDeletionRequest $request
     * @return ScheduleKeyDeletionResponse ScheduleKeyDeletionResponse
     */
    public function scheduleKeyDeletion($request){
        return $this->_kmsClient->scheduleKeyDeletion($request);
    }

    /**
     * 带运行参数调用ScheduleKeyDeletion接口申请删除一个指定的主密钥（CMK)

     * @param ScheduleKeyDeletionRequest $request
     * @param RuntimeOptions $runtime
     * @return ScheduleKeyDeletionResponse ScheduleKeyDeletionResponse
     */
    public function scheduleKeyDeletionWithOptions($request, $runtime){
        return $this->_kmsClient->scheduleKeyDeletionWithOptions($request, $runtime);
    }

    /**
     * 调用SetDeletionProtection接口为用户主密钥（CMK）开启或关闭删除保护

     * @param SetDeletionProtectionRequest $request
     * @return SetDeletionProtectionResponse SetDeletionProtectionResponse
     */
    public function setDeletionProtection($request){
        return $this->_kmsClient->setDeletionProtection($request);
    }

    /**
     * 带运行参数调用SetDeletionProtection接口为用户主密钥（CMK）开启或关闭删除保护

     * @param SetDeletionProtectionRequest $request
     * @param RuntimeOptions $runtime
     * @return SetDeletionProtectionResponse SetDeletionProtectionResponse
     */
    public function setDeletionProtectionWithOptions($request, $runtime){
        return $this->_kmsClient->setDeletionProtectionWithOptions($request, $runtime);
    }

    /**
     * 调用TagResource接口为主密钥、凭据或证书绑定标签

     * @param TagResourceRequest $request
     * @return TagResourceResponse TagResourceResponse
     */
    public function tagResource($request){
        return $this->_kmsClient->tagResource($request);
    }

    /**
     * 带运行参数调用TagResource接口为主密钥、凭据或证书绑定标签

     * @param TagResourceRequest $request
     * @param RuntimeOptions $runtime
     * @return TagResourceResponse TagResourceResponse
     */
    public function tagResourceWithOptions($request, $runtime){
        return $this->_kmsClient->tagResourceWithOptions($request, $runtime);
    }

    /**
     * 调用UntagResource接口为主密钥、凭据或证书解绑标签

     * @param UntagResourceRequest $request
     * @return UntagResourceResponse UntagResourceResponse
     */
    public function untagResource($request){
        return $this->_kmsClient->untagResource($request);
    }

    /**
     * 带运行参数调用UntagResource接口为主密钥、凭据或证书解绑标签

     * @param UntagResourceRequest $request
     * @param RuntimeOptions $runtime
     * @return UntagResourceResponse UntagResourceResponse
     */
    public function untagResourceWithOptions($request, $runtime){
        return $this->_kmsClient->untagResourceWithOptions($request, $runtime);
    }

    /**
     * 调用UpdateAlias接口更新已存在的别名所代表的主密钥（CMK）ID

     * @param UpdateAliasRequest $request
     * @return UpdateAliasResponse UpdateAliasResponse
     */
    public function updateAlias($request){
        return $this->_kmsClient->updateAlias($request);
    }

    /**
     * 带运行参数调用UpdateAlias接口更新已存在的别名所代表的主密钥（CMK）ID

     * @param UpdateAliasRequest $request
     * @param RuntimeOptions $runtime
     * @return UpdateAliasResponse UpdateAliasResponse
     */
    public function updateAliasWithOptions($request, $runtime){
        return $this->_kmsClient->updateAliasWithOptions($request, $runtime);
    }

    /**
     * 调用UpdateKeyDescription接口更新主密钥的描述信息

     * @param UpdateKeyDescriptionRequest $request
     * @return UpdateKeyDescriptionResponse UpdateKeyDescriptionResponse
     */
    public function updateKeyDescription($request){
        return $this->_kmsClient->updateKeyDescription($request);
    }

    /**
     * 带运行参数调用UpdateKeyDescription接口更新主密钥的描述信息

     * @param UpdateKeyDescriptionRequest $request
     * @param RuntimeOptions $runtime
     * @return UpdateKeyDescriptionResponse UpdateKeyDescriptionResponse
     */
    public function updateKeyDescriptionWithOptions($request, $runtime){
        return $this->_kmsClient->updateKeyDescriptionWithOptions($request, $runtime);
    }

    /**
     * 调用UpdateRotationPolicy接口更新密钥轮转策略

     * @param UpdateRotationPolicyRequest $request
     * @return UpdateRotationPolicyResponse UpdateRotationPolicyResponse
     */
    public function updateRotationPolicy($request){
        return $this->_kmsClient->updateRotationPolicy($request);
    }

    /**
     * 带运行参数调用UpdateRotationPolicy接口更新密钥轮转策略

     * @param UpdateRotationPolicyRequest $request
     * @param RuntimeOptions $runtime
     * @return UpdateRotationPolicyResponse UpdateRotationPolicyResponse
     */
    public function updateRotationPolicyWithOptions($request, $runtime){
        return $this->_kmsClient->updateRotationPolicyWithOptions($request, $runtime);
    }

    /**
     * 调用UpdateSecret接口更新凭据的元数据

     * @param UpdateSecretRequest $request
     * @return UpdateSecretResponse UpdateSecretResponse
     */
    public function updateSecret($request){
        return $this->_kmsClient->updateSecret($request);
    }

    /**
     * 带运行参数调用UpdateSecret接口更新凭据的元数据

     * @param UpdateSecretRequest $request
     * @param RuntimeOptions $runtime
     * @return UpdateSecretResponse UpdateSecretResponse
     */
    public function updateSecretWithOptions($request, $runtime){
        return $this->_kmsClient->updateSecretWithOptions($request, $runtime);
    }

    /**
     * 调用UpdateSecretRotationPolicy接口更新凭据轮转策略

     * @param UpdateSecretRotationPolicyRequest $request
     * @return UpdateSecretRotationPolicyResponse UpdateSecretRotationPolicyResponse
     */
    public function updateSecretRotationPolicy($request){
        return $this->_kmsClient->updateSecretRotationPolicy($request);
    }

    /**
     * 带运行参数调用UpdateSecretRotationPolicy接口更新凭据轮转策略

     * @param UpdateSecretRotationPolicyRequest $request
     * @param RuntimeOptions $runtime
     * @return UpdateSecretRotationPolicyResponse UpdateSecretRotationPolicyResponse
     */
    public function updateSecretRotationPolicyWithOptions($request, $runtime){
        return $this->_kmsClient->updateSecretRotationPolicyWithOptions($request, $runtime);
    }

    /**
     * 调用UpdateSecretVersionStage接口更新凭据的版本状态

     * @param UpdateSecretVersionStageRequest $request
     * @return UpdateSecretVersionStageResponse UpdateSecretVersionStageResponse
     */
    public function updateSecretVersionStage($request){
        return $this->_kmsClient->updateSecretVersionStage($request);
    }

    /**
     * 带运行参数调用UpdateSecretVersionStage接口更新凭据的版本状态

     * @param UpdateSecretVersionStageRequest $request
     * @param RuntimeOptions $runtime
     * @return UpdateSecretVersionStageResponse UpdateSecretVersionStageResponse
     */
    public function updateSecretVersionStageWithOptions($request, $runtime){
        return $this->_kmsClient->updateSecretVersionStageWithOptions($request, $runtime);
    }

    /**
     * 调用OpenKmsService接口为当前阿里云账号开通密钥管理服务

     * @return OpenKmsServiceResponse OpenKmsServiceResponse
     */
    public function openKmsService(){
        return $this->_kmsClient->openKmsService();
    }

    /**
     * 带运行参数调用OpenKmsService接口为当前阿里云账号开通密钥管理服务

     * @param RuntimeOptions $runtime
     * @return OpenKmsServiceResponse OpenKmsServiceResponse
     */
    public function openKmsServiceWithOptions($runtime){
        return $this->_kmsClient->openKmsServiceWithOptions($runtime);
    }

    /**
     * 调用DescribeRegions接口查询当前账号的可用地域列表

     * @return DescribeRegionsResponse DescribeRegionsResponse
     */
    public function describeRegions(){
        return $this->_kmsClient->describeRegions();
    }

    /**
     * 带运行参数调用DescribeRegions接口查询当前账号的可用地域列表

     * @param RuntimeOptions $runtime
     * @return DescribeRegionsResponse DescribeRegionsResponse
     */
    public function describeRegionsWithOptions($runtime){
        return $this->_kmsClient->describeRegionsWithOptions($runtime);
    }

    /**
     * 调用DescribeAccountKmsStatus接口查询当前阿里云账号的密钥管理服务状态

     * @return DescribeAccountKmsStatusResponse DescribeAccountKmsStatusResponse
     */
    public function describeAccountKmsStatus(){
        return $this->_kmsClient->describeAccountKmsStatus();
    }

    /**
     * 带运行参数调用DescribeAccountKmsStatus接口查询当前阿里云账号的密钥管理服务状态

     * @param RuntimeOptions $runtime
     * @return DescribeAccountKmsStatusResponse DescribeAccountKmsStatusResponse
     */
    public function describeAccountKmsStatusWithOptions($runtime){
        return $this->_kmsClient->describeAccountKmsStatusWithOptions($runtime);
    }

    /**
     * 调用GetSecretValue接口获取共享网关凭据值

     * @param GetSecretValueRequest $request
     * @return GetSecretValueResponse GetSecretValueResponse
     */
    public function getSecretValueBySharedEndpoint($request){
        return $this->_kmsClient->getSecretValue($request);
    }

    /**
     * 带运行参数调用GetSecretValue接口获取共享网关凭据值

     * @param GetSecretValueRequest $request
     * @param RuntimeOptions $runtime
     * @return GetSecretValueResponse GetSecretValueResponse
     */
    public function getSecretValueWithOptionsBySharedEndpoint($request, $runtime){
        return $this->_kmsClient->getSecretValueWithOptions($request, $runtime);
    }

    /**
     * 调用GetPublicKey接口获取共享网关非对称密钥的公钥

     * @param GetPublicKeyRequest $request
     * @return GetPublicKeyResponse GetPublicKeyResponse
     */
    public function getPublicKeyBySharedEndpoint($request){
        return $this->_kmsClient->getPublicKey($request);
    }

    /**
     * 带运行参数调用GetPublicKey接口获取共享网关非对称密钥的公钥

     * @param GetPublicKeyRequest $request
     * @param RuntimeOptions $runtime
     * @return GetPublicKeyResponse GetPublicKeyResponse
     */
    public function getPublicKeyWithOptionsBySharedEndpoint($request, $runtime){
        return $this->_kmsClient->getPublicKeyWithOptions($request, $runtime);
    }
}
