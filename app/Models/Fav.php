<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * 2020-06-08 - Autor: Jovana Jankovic 0586/17, verzija 0.3
 * 
 * Favoriti Model sadrzi neophodne podatke o korisnikovim favoritima jela
 * Za svaki primarni kljuc je vezan id korisnika i id jela koje je korisnik obelezio kao omiljeno
 *
 *  */

class Fav extends Model
{
    protected $table      = 'fav';
    protected $primaryKey = 'fav_id';
    protected $returnType     = 'object';
    protected $allowedFields = ['fav_id','fav_kor_id', 'fav_jelo_id'];

    protected $validationRules    = [
                    'fav_kor_id'   => 'trim|required',
                    'fav_jelo_id' => 'trim|required'
            ];
    protected $validationMessages = [
                'fav_kor_id' => ['required' => 'Id korisnika je obavezan'],
                'fav_jelo_id' => ['required' => 'Id jela je obavezno']
            ];
    
    protected $skipValidation = false;
    protected $updatedField='';
       
    /** public function insert($data=NULL, $returnID=true) {...}
     * Kreiranje nove instance Favorita za korisnika 
     * 
     * @param Array $data
     * @param bool $returnID
     * @return String vraca dekodovanu vrednost novo-insertovanog id favorita
     */
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['fav_id'] = $id;
        if (array_key_exists('fav_kor_id', $data)) {
            $data['fav_kor_id'] = \UUID::codeId($data['fav_kor_id']);
        }
        if (array_key_exists('fav_jelo_id', $data)) {
            $data['fav_jelo_id'] = \UUID::codeId($data['fav_jelo_id']);
        }
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
     /** public function update($id=NULL, $data=NULL):bool {...}
     * Update postojeceg favorita
     * 
     * @param string $id id konkretnog favorita korisnika za koji zelimo da uradimo azuriranje u bazi 
     * @param Array $data niz informacija za odredjeni favorit
     * @return bool
     */
    public function update($id=NULL, $data=NULL):bool 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('fav_kor_id', $data)) {
            $data['fav_kor_id'] = \UUID::codeId($data['fav_kor_id']);
        }
        if (array_key_exists('fav_jelo_id', $data)){
            $data['fav_jelo_id'] = \UUID::codeId($data['fav_jelo_id']);
        }
        if(parent::update($id, $data) === false){
            return false;
        }
        return true;
    }
    
    /**public function delete($id=NULL, $purge=false) {...}
     * Brisanje favorita iz baze
     * 
     * @param string $id id favorita koji zelimo da obrisemo iz baze
     * @param bool $purge
     * @return void
     */
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    /**public function dohvatiFavorit($id){...}
     * Dohvata se ceo red tabele na osnovu primarnog kljuca
     * 
     * @param string $id primarni kljuc iz tabele Fav
     * @return object jedan red iz tabele favoriti
     */
    public function dohvatiFavorit($id){
        $id = \UUID::codeId($id);
        $row = $this->find($id);
        return $this->decodeRecord($row);
    }
    
    /**  public function dohvatiFavoriteZaKorisnika($fav_kor_id){...}
     * Dohvata sve favorite odredjenog korisnika na osnovu njegovog id
     * 
     * @param String $fav_kor_id id korisnika
     * @return Array niz favorita odredjenog korisnika
     */
      public function dohvatiFavoriteZaKorisnika($fav_kor_id){
          $kor_id=\UUID::codeId($fav_kor_id);
          $favorit= $this->where('fav_kor_id',$kor_id)->findAll();
         $favorit= $this->decodeArray($favorit);
          //return $favorit[0]->fav_jelo_id;
         return $favorit;
    }
    
  /**   public function decodeRecord($row){...}
    * Dekoduje vrednosti kljuceva iz jednog reda posto se u tom redu tabele nalaze kodovane vrednosti
    * U zadatku uvek radimo sa dekodovanim vrednostima, pa nam je ova funkcija zbog toga neophodna
    * 
    * @param Array $row jedan red iz tabele sa kodovanim vrednostima id
    * @return Array dekodovan jedan red iz tabele
    */
      public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->fav_id = \UUID::decodeId($row->fav_id);
        $row->fav_kor_id = \UUID::decodeId($row->fav_kor_id);
        $row->fav_jelo_id = \UUID::decodeId($row->fav_jelo_id);
        return $row;  
    }
    
   /** public function decodeArray($finds){...}
    * Dekoduje vrednosti kljuceva iz niza posto se u tom nizu nalaze kodovane vrednosti
    * U zadatku uvek radimo sa dekodovanim vrednostima, pa nam je ova funkcija zbog toga neophodna
    * 
    * @param Array $row niz sa kodovanim vrednostima id
    * @return Array dekodovan niz
    */
      public function decodeArray($finds)
    {
        //dekodujemo sve kljuceve
        for ($i = 0; $i < count($finds); $i++) {
            $finds[$i] = $this->decodeRecord($finds[$i]);
        }
        return $finds;  
    }

    //-----------------------------------------------------------------------
    /** public function jeFavorit($id_jela, $id_kor){...}
     * Proverava da li je dato jelo favorit datog korisnika 
     * 
     * @param string $id_jela
     * @param string $id_kor
     * 
     * @return bool
     */
    public function jeFavorit($id_jela, $id_kor)
    {
        $jelo_id = \UUID::codeId($id_jela);
        $kor_id = \UUID::codeId($id_kor);
        $ima = $this->where('fav_jelo_id', $jelo_id)->where('fav_kor_id', $kor_id)->findAll();
    
        if (count($ima) > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    
    //-----------------------------------------------------------------------
    /** public function idFavorita($id_jela, $id_kor){...}
     * dohvata id odredjenog favorita, ako on postoji
     * 
     * @param string $id_jela
     * @param string $id_kor
     * 
     * @return null|string
     */
    public function idFavorita($id_jela, $id_kor)
    {
        $jelo_id = \UUID::codeId($id_jela);
        $kor_id = \UUID::codeId($id_kor);
        $ima = $this->where('fav_jelo_id', $jelo_id)->where('fav_kor_id', $kor_id)->findAll();
        if (count($ima)==0) return null;
        return \UUID::decodeId($ima[0]->fav_id);
    }
}