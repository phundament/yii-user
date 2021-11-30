<?php

class IpTables
{
    
    public static function validate($user_id)
    {
        
        if (empty($_SERVER['REMOTE_ADDR'])) {
            return false;
        }
        
        $long_ip = self::_ip2long($_SERVER['REMOTE_ADDR']);
        
        if ($long_ip === false) {
            return false;
        }
        
        $criteria = new CDbCriteria();
        $criteria->compare('t.uxip_user_id', $user_id);
        $user_ip_list = UxipUserXIpTable::model()->findAll($criteria);
        
        foreach ($user_ip_list as $user_ip) {
            
            $ip = IptbIpTable::model()->findByPk($user_ip->uxip_iptb_id);
            
            if ($ip->iptb_status == BaseIptbIpTable::IPTB_STATUS_ACTIVE) {
                
                $long_from = self::_ip2long($ip->iptb_from);
                $long_to   = self::_ip2long($ip->iptb_to);
                
                if ($long_from === false || $long_to === false) {
                    continue;
                }
                
                if ($long_ip >= $long_from && $long_ip <= $long_to) {
                    return true;
                }
                
            }
            
        }
        
        return false;
        
    }
    
    private static function _ip2long($ip)
    {
        
        $pattern = '#^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$#';
        
        if (!preg_match($pattern, $ip)) {
            return false;
        }
        
        if (substr($ip, 0, 3) > 127) {
            $long_ip = ((ip2long($ip) & 0x7FFFFFFF) + 0x80000000);
        } else {
            $long_ip = ip2long($ip);
        }
        
        return $long_ip;
        
    }
    
}

