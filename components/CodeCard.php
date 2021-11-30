<?php

class CodeCard
{
    
    private static $_requestTypes = array(
        'create_card',
        'change_card',
        'logon',
        'delete_user',
        'validate_code'
    );
    
    public static function request($request, &$reply)
    {
        
        if (!in_array($request['request_type'], self::$_requestTypes)) {
            $reply['error'] = 'Unknown request';
            return false;
        }
        
        Yii::import('vendor.phpseclib.phpseclib.phpseclib.Crypt.AES');
        
        $code_card = Yii::app()->getModule('user')->codeCard;
        
        $apy_key   = $code_card['apy_key'];
        $crypt_key = $code_card['crypt_key'];
        $host      = $code_card['host'];
        
        $json_request = json_encode($request);
        $enc_request  = self::_cryptRequest($json_request, $crypt_key);
        
        $url = $host . $apy_key . self::_requestSeperator() . $enc_request;
        
        if (!$message = file_get_contents($url)) {
            $reply['error'] = 'Request failed';
            return false;
        }
        
        $json_message = self::_decryptMessage($message, $crypt_key);
        
        $reply = json_decode($json_message, true);
        
        return true;
        
    }
    
    private static function _base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_~');
    }

    private static function _base64_url_decode($input)
    {
        return base64_decode(strtr($input, '-_~', '+/='));
    }

    private static function _requestSeperator()
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklopqrstuvwxyz0123456789';
        return $str[rand(0, strlen($str)-1)];
    }
    
    private static function _cryptRequest($data, $crypt_key)
    {
        $cipher = new Crypt_AES(CRYPT_AES_MODE_CTR);
        $cipher->setKey($crypt_key);
        return self::_base64_url_encode($cipher->encrypt($data));
    }
    
    private static function _decryptMessage($data, $crypt_key)
    {
        $cipher = new Crypt_AES(CRYPT_AES_MODE_CTR);
        $cipher->setKey($crypt_key);
        return $cipher->decrypt(self::_base64_url_decode($data));
    }
    
}

