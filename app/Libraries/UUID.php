<?php
// 2020-05-14 v0.2 Jovana Pavic 2017

/**
 * UUID - klasa koja sluzi za generisanje jedinstvenog
 *        kljuca, za njegovo kodiranje u binarnu vrednost 
 *        i dekodovanje u heksa vrednost  
 * 
 * @version 0.2
 */
class UUID {
    
    /**
     * public static function genereteId(){...}
     *  Poziva generisanje kljuca, vraca hexa vrednost
     * 
     * @return string Hexa vrednost novog kljuca
     */
    public static function generateId()
    {
        $id = hex2bin(\UUID::v4());
        return $id;
    }
    
    /**
     * public static function decodeId(){...}
     *  Pretvara dobijeni kljuc iz binarne vrednosti 
     *   u hexa vrednost 
     * 
     * @param string $id Binarna vrednost kljuca
     * 
     * @return string Hexa vrednost kljuca
     */
    public static function decodeId($id)
    {
        return bin2hex($id);
    }
    
    /**
     * public static function codeId(){...}
     *  Pretvara dobijeni kljuc iz hexa vrednosti 
     *   u binarnu vrednost 
     * 
     * @param string $id Hexa vrednost kljuca
     * 
     * @return string Binarna vrednost kljuca
     */
    public static function codeId($id)
    {
        return hex2bin($id);
    }
    
    /**
     * public static function v4(){...}
     *  Generisanje kljuc velicine 16B, 
     *   vraca njegovu binarnu vrednost
     * 
     * @return string Binarna vrednost novog kljuca
     */
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
