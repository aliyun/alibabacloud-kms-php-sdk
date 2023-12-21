<?php

namespace AlibabaCloud\Kms\Kms20160120\Models;


class KmsConfig extends \AlibabaCloud\Dkms\Gcs\OpenApi\Models\Config
{
    /**
     * 默认使用KMS共享网关的接口API Name列表
     * @var array
     */
    public $defaultKmsApiNames;

    /**
     * 指定所有接口使用到的字符集编码
     * @var string
     */
    public $charset;

    /**
     * ssl验证开关,默认为false,即需验证ssl证书;为true时,表示可在调用接口时设置是否忽略ssl证书
     * @var string
     */
    public $ignoreSSLVerifySwitch;

    /**
     * 强制使用低级转换接口 默认是false, 默认使用高级转换接口
     * @var bool
     */
    public $forceLowVersionCryptoTransfer;

}