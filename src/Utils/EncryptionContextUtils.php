<?php

namespace AlibabaCloud\Kms\Kms20160120\Utils;

class EncryptionContextUtils
{
    /**
     * @param array $encryptionContext
     * @return string
     */
    public static function encodeEncryptionContext($encryptionContext)
    {
        ksort($encryptionContext);
        $context = "";
        $count = count($encryptionContext);
        foreach ($encryptionContext as $key => $value)
        {
            $context .= $key . "=" . $value;
            if(--$count > 0){
                $context .= "&";
            }
        }
        return hash("sha256", $context);
    }

}