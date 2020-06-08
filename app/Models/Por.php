<?php namespace App\Models;
// 2020-05-17 v0.3 Jovana Pavic 2017/0099

/*
  !!!   Pre pristupanja bazi svaki id treba kodirati sa |||
  !!!           \UUID::codeId($id);                     !!!
 */

use CodeIgniter\Model;

/**
 * Por - klasa model, koja sluzi za komunikaciju sa bazom
 *       dohvatanje, izmena i uklanjanje iz tabele Por
 * 
 * @version 0.3
 */
class Por extends Model
{
    /*
    //por_datkre - datum kada je korpa kreirana
    //por_datpor - datum kada je kliknuto dugme poruci
    */
    protected $table      = 'por';
    protected $primaryKey = 'por_id';
    
    protected $returnType     = 'object';
 
    protected $allowedFields = [
                                'por_id', 
                                'por_kor_id', 
                                'por_naziv', 
                                'por_povod_id', 
                                'por_br_osoba', 
                                'por_za_dat', 
                                'por_popust_proc', 
                                'por_datporuc', 
                                'por_datodluke',
                                'por_odluka',
                                'por_datizrade',
                                'por_datpreuz'
                            ];
 
    protected $useTimestamps = true;
    protected $createdField  = 'por_datkre';
    protected $updatedField = '';
    protected $dateFormat = 'datetime';

    protected $validationRules    = [
                    'por_kor_id'   => 'trim|required'
            ];
    protected $validationMessages = [
                'por_kor_id' => ['required' => 'Id korisnika je obavezan']
            ];
    protected $skipValidation     = false;

    
    //-----------------------------------------------------------------------
    
    /*
    // Metoda save ne mora da se overrid-uje jer ona samo poziva
    //  insert i update u zavisnosti od parametara
    // Preporucljivo koristiti insert i update jer insert vraca id
    */
    
    //-----------------------------------------------    
    /** public function insert($data=NULL,$returnID=true){...}
     * Omotac funkcjie Model::insert
     * Ako je neuspesno vraca false
     * Ako je uspesno vraca id
     * 
     * @param array|object $data
     * @param boolean      $returnID Da li insert ID treba da se vrati ili ne
     *
     * @return integer|string|boolean
     * @throws \ReflectionException
     */
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['por_id'] = $id;
        if (array_key_exists('por_kor_id', $data)) {
            $data['por_kor_id'] = \UUID::codeId($data['por_kor_id']);
        }
        if (array_key_exists('por_povod_id', $data)) {
            $data['por_povod_id'] = \UUID::codeId($data['por_povod_id']);
        }
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    //-----------------------------------------------
    /**public function update($id=NULL,$data=NULL):bool{...}
     * Omotac funkcije Model::update
     * Ako je uspesno vraca true, ako nije vraca false
     * 
     * @param integer|array|string $id
     * @param array|object         $data
     *
     * @return boolean
     * @throws \ReflectionException
     */
    public function update($id=NULL, $data=NULL):bool
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('por_kor_id', $data)) {
            $data['por_kor_id'] = \UUID::codeId($data['por_kor_id']);
        }
        if (array_key_exists('por_povod_id', $data)) {
            $data['por_povod_id'] = \UUID::codeId($data['por_povod_id']);
        }
        if(parent::update($id, $data) === false){
            return false;
        }
        return true;
    }
    
    //-----------------------------------------------
    /** public function delete($id=NULL,$purge=false){...} 
     * Omotac funkcije Model::delete
     * Dozvoljeno je brisanje, ali je potrebno prebaciti 
     *  kljuc u odgovarajuci format
     * 
     * @param integer|string|array|null $id    The rows primary key(s)
     * @param boolean                   $purge Allows overriding the soft deletes setting.
     *
     * @return mixed
     * @throws \CodeIgniter\Database\Exceptions\DatabaseException
     */
    public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    //-----------------------------------------------
    /** public function porudzbineKorisnika($kor_id){..}
     * Dohvata sve porudzbine korisnika sa zadatim id-em
     * 
     * @param string $kor_id
     * 
     * @return array
     */
    public function porudzbineKorisnika($kor_id)
    {
        $kor_id = \UUID::codeID($kor_id);
        $finds = $this->where('por_kor_id', $kor_id)->findAll();
           
        return $this->decodeArray($finds);
    }
    
    //------------------------------------------------
    /** Autor: Filip Lucic 0188/17 - funkcija dohvata porudzbine korisnika koje su porucene (nisu korpa)*/
    public function poslatePorudzbineKorisnika ($kor_id) {
        $kor_id = \UUID::codeID($kor_id);
        $finds = $this->where('por_kor_id', $kor_id)->where('por_datporuc!=',null)->findAll();        
        return $this->decodeArray($finds);       
    }
    
    //------------------------------------------------
    /** Autor: Filip Lucic 0188/17 - funkcija dohvata sve porudzbine koje nisu korpa*/
    public function svePoslatePorudzbine () {
        $porudzbine=$this->where('por_datporuc!=', null)->findAll();
        $porudzbine=$this->decodeArray($porudzbine);
        return $porudzbine;
    }
    
        
    //-----------------------------------------------
    /** public function korpaKorisnika($kor_id){...}
     * Dohvata porudzbinu korisnika sa zadatim id-em
     *  koja nije jos porucena
     * Ako korpa postoji vraca njen id,
     * Ako korpa ne postoji vraca null
     * 
     * @param string $kor_id
     * 
     * @return string
     */
    public function korpaKorisnika($kor_id)
    {
        $kor_id = \UUID::codeId($kor_id);
        $finds = $this->where('por_kor_id', $kor_id)->
                where('por_datporuc', null)->findAll();
        
        //ako nema korpu
        if(count($finds) == 0){
            return null;
        }
        
        $por_id = $finds[0]->por_id;
        $por_id = \UUID::decodeId($por_id);
        return $por_id;
    }    

    //-----------------------------------------------
    /** public function filtriranePorudzbineKorisnika($kor_id,$status){...}
     * Dohvata neke porudzbine korisnika sa zadatim id-em
     * Potrebno za prikaz filtriranih porudzbina korisnika 
     * status: 0-na cekanju, 1-prihvacene, 2-odbijena, 
     *  3-gotova, 4-pokupljena    
     * 
     * @param string $kor_id
     * @param int $status
     * 
     * @return array
     */
    public function filtriranePorudzbineKorisnika($kor_id, $status)
    {
        $kor_id = \UUID::codeId($kor_id);
        $finds = null;
        if($status == 0) {
            //nije doneta odluka
            $finds = $this->where('por_kor_id', $kor_id)
                    ->where('por_datodluke', null)->findAll();
        }
        else if($status == 1) {
            //prihvacena porudzbina
            $finds = $this->where('por_kor_id', $kor_id)
                    ->like('por_odluka', 'accepted')->findAll();
        }
        else if($status == 2) {
            //odbijena porudzbina
            $finds = $this->where('por_kor_id', $kor_id)
                    ->like('por_odluka', 'declined')->findAll();
        }
        else if($status == 3) {
            //gotova
            $finds = $this->where('por_kor_id', $kor_id)
                    ->where('por_datizrade !=', null)->findAll();
        }
        else if($status == 4) {
            $finds = $this->where('por_kor_id', $kor_id)
                    ->where('por_datpreuz !=', null)->findAll();
        }
        
        return $this->decodeArray($finds);
        
    }
    
    //-----------------------------------------------
    /** public function donetaOdluka($por_id,$odluka){...}
     * Upisuje datum odluke i donesenu odluku
     *  u porudzbinu sa datim id-em
     * 
     * @param string $por_id
     * @param string $odluka
     */
    public function donetaOdluka($por_id, $odluka)
    {
        //ne radi se codeId jer ga radi update
        $this->update($por_id, ['por_odluka' => $odluka, 
                                'por_datodluke' => date('Y-m-d H:i:s')
            ]);
    }    
    
    //------------------------------------------------
    /** public function dohvati($por_id){...}
     * Dohvata porudzbinu sa datim id-em
     * 
     * @param string $por_id
     * 
     * @return object
     */
    public function dohvati($por_id)    
    {
        $por_id = \UUID::codeId($por_id);
        $row = $this->find($por_id);
        
        return $this->decodeRecord($row);
    }
    
    //------------------------------------------------
    /** public function imaPopust($por_id){...}
     * Proverava da li data porudzbina ima popust
     *
     * @param string $por_id 
     * 
     * @return bool
    */
    public function imaPopust($por_id)
    {
        $por = $this->find(\UUID::codeId($por_id));
        if ($por->por_popust_proc > 0) {
            return true;
        }
        return false;
    }
    
    //--------------------------------------------------
    /**public function dohvatiSvePorudzbine(){..}
     * Dohvatanje svih porudzbina koje postoje u bazi podataka
     * 
     * @return Array niz svih porudzbina
     */
    public function dohvatiSvePorudzbine(){
        $porudzbine=$this->findAll();
        $porudzbine=$this->decodeArray($porudzbine);
        return $porudzbine;
    }

    //------------------------------------------------
    /**public function zaPravljenje(){...}
     * Dohvata sve porudzbine koje nisu napravljene
     * 
     * @return array
     */
    public function zaPravljenje()
    {
        $svePor = $this->where('por_odluka', 'prihvacena')->where('por_datizrade', null)->
                findAll();
        return $this->decodeArray($svePor);
    }    
    
    //------------------------------------------------
    /**public function napravljena(){...}
     * Prosledjenoj poruzbini stavlja trenutni datum kao datum izrade
     * 
     * @param string $por_id
     */
    public function napravljena($por_id)
    {
        $this->update($por_id, ['por_datizrade' => date('Y-m-d H:i:s')]);
    }    
    
    //------------------------------------------------
    /** public function decodeRecord($row){...}
     * Dekodovanje sve kljuceve unutar jednog rekorda
     * 
     * @param object $row Objekat koji je vratila baza
     * 
     * @return object Primljeni objekat sa dekodovanim kljucevima
     */
    public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->por_id = \UUID::decodeId($row->por_id);
        $row->por_kor_id = \UUID::decodeId($row->por_kor_id);
        $row->por_povod_id = \UUID::decodeId($row->por_povod_id);
        return $row;  
    }
    
    //------------------------------------------------
    /** public function decodeArray($finds){...}
     * Dekodovanje nizova podataka
     * 
     * @param array $finds Niz objekata koji je vratila baza
     * 
     * @return array Primljeni niz sa dekodovanim kljucevima
     */
    public function decodeArray($finds)
    {
        //dekodujemo sve kljuceve
        for ($i = 0; $i < count($finds); $i++) {
            $finds[$i] = $this->decodeRecord($finds[$i]);
        }
        return $finds;  
    }
        
}