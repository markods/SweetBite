<?php
//klasa za povezivanje sa bazom podataka
//singleton, moze da se napravi samo jedna konekcija sa bazom
class DB {
    private static $instanca = NULL;

    private function __construct() {}

    private function __clone() {} //ovako se zabrani kopiranje, mora da se to uradi da bi bilo singelton

    public static function getInstanca() {
      if (!isset(self::$instanca)) {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        
        //povezujemo se preko PDO
        //PDO je klasa ugradjena u PHP
        //PDO prikazuje konekciju izmedju PHP i DB servera
        self::$instanca = new PDO('mysql:host=localhost;port=3308;dbname=slatkizalogaj', 'root', '', $pdo_options);
      }
      return self::$instanca;
    }
  }
?>