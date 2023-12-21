<?php

namespace AlibabaCloud\Kms\Kms20160120\Utils;

class Constants
{
    const GCM_IV_LENGTH = 12;
    const EKT_ID_LENGTH = 36;
    const DIGEST_MESSAGE_TYPE = "DIGEST";
    const KMS_KEY_PAIR_AES_256 = "AES_256";
    const KMS_KEY_PAIR_AES_128 = "AES_128";
    const MIGRATION_KEY_VERSION_ID_KEY = "x-kms-migrationkeyversionid";
    const NUMBER_OF_BYTES_AES_256 = 32;
    const NUMBER_OF_BYTES_AES_128 = 16;
    const MAGIC_NUM = '$';
    const MAGIC_NUM_LENGTH = 1;
    const CIPHER_VER_AND_PADDING_MODE_LENGTH = 1;
    const ALGORITHM_LENGTH = 1;
    const CIPHER_VER = 0;
    const ALG_AES_GCM = 2;
    const HTTP_OK = 200;
    const SDK_NAME = "alibabacloud-kms-php-sdk";
    const SDK_VERSION = "0.4.0";
    const CLIENT_USER_AGENT = self::SDK_NAME . "-client/" . self::SDK_VERSION;
    const TRANSFER_CLIENT_USER_AGENT = self::SDK_NAME . "-transfer-client/" . self::SDK_VERSION;
}
