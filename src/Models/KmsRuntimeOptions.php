<?php

namespace AlibabaCloud\Kms\Kms20160120\Models;

use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;

class KmsRuntimeOptions extends RuntimeOptions
{
    /**
     * 是否使用KMS共享网关
     */
    public $isUseKmsShareGateway;
    /**
     * 指定使用到的字符集编码
     */
    public $charset;

}