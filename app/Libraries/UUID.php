<?php
// 2020-05-14 v0.2 Jovana Pavic 2017

class UUID {
    
    //poziva generisanje id-a, vraca bin vrednost
    public static function generateId()
    {
        $id = hex2bin(\UUID::v4());
        return $id;
    }
    
    //id pretvara u hex vrednust koja je citljivija
    public static function decodeId($id)
    {
        return bin2hex($id);
    }
    
    //vraca id u oblik u kome je u bazi
    public static function codeId($id)
    {
        return hex2bin($id);
    }
    
    //stvara id, vraca  hex vrednost velicine 16B
    protected static function v4() 
    {
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',

        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }  
    
}
