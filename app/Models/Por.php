<?php namespace App\Models;
// 2020-05-17 v0.3 Jovana Pavic 2017

/*
  !!!   Pre pristupanja bazi svaki id treba kodirati sa |||
  !!!           \UUID::codeId($id);                     !!!
 */

use CodeIgniter\Model;

class Por extends Model
{
    /*
    //Tu se upisuje korpa za ulogovanog korisnika, 
    //a datum porucivanja se naknadno popuni
    //por_datkre - datum kada je korpa kreirana
    //por_datpor - datum kada je kliknuto dugme poruci
    //kolone u tabeli: por_id, por_kor_id, por_naziv, por_povod_id,
    //                  por_br_osoba, por_za_dat, por_popust_proc,
    //                  por_datkre, por_datporuc, por_datodluke,
    //                  por_odluka, por_datizrade, por_datpreuz
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
    //override osnovnih metoda tako da prikazuju greske
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    //preporucljivo koristiti insert i update jer insert vraca id
    //dobro za razvojnu fazu
    */
    
    //-----------------------------------------------    
    /** public function insert($data=NULL,$returnID=true){...}
    //ako je neuspesno vraca false
    //ako je uspesno vraca id
    */
    
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['por_id'] = $id;
        if (array_key_exists('por_kor_id', $data)) {
            $data['por_kor_id'] = \UUID::codeId($data['por_kor_id']);
        }
        if (array_key_exists('povod_id', $data)) {
            $data['por_povod_id'] = \UUID::codeId($data['por_povod_id']);
        }
        if(parent::insert($data, $returnID) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    //-----------------------------------------------
    /**public function update($id=NULL,$data=NULL):bool{...}
    //ako je uspesno vraca true, ako nije vraca false
    */
    
    public function update($id=NULL, $data=NULL):bool
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('por_kor_id', $data)) {
            $data['por_kor_id'] = \UUID::codeId($data['por_kor_id']);
        }
        if (array_key_exists('povod_id', $data)) {
            $data['por_povod_id'] = \UUID::codeId($data['por_povod_id']);
        }
        if(parent::update($id, $data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
    }
    
    //-----------------------------------------------
    /** public function delete($id=NULL,$purge=false){...} 
    //dozvoljeno je brisanje, ali je potrebno prebaciti 
    //kljuc u odgovarajuci format
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
    //Dohvata sve porudzbine korisnika sa zadatim id-em
    //Potrebnoo za prikaz porudzbina korisnika
    */
    
    public function porudzbineKorisnika($kor_id)
    {
        $kor_id = \UUID::codeID($kor_id);
        $finds = $this->where('por_kor_id', $kor_id)->findAll();
           
        return $this->decodeArray($finds);
    }
        
    //-----------------------------------------------
    /** public function korpaKorisnika($kor_id){...}
    //Dohvata porudzbinu korisnika sa zadatim id-em
    //Koja nije jos porucena
    //Potrebno za prikaz korpe korisnika
    // Ako korpa postoji vraca njen id,
    // Ako korpa ne postoji vraca null
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
    //Dohvata neke porudzbine korisnika sa zadatim id-em
    //Potrebno za prikaz filtriranih porudzbina korisnika 
    //status: 0-na cekanju, 1-prihvacene, 2-odbijena, 
    //3-gotova, 4-pokupljena    
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
    //Upisuje datum odluke i donesenu odluku
    //u porudzbinu sa datim id-em
    //odluka: 0-prihvacena, 1-odbijena
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
    //Dohvata porudzbinu sa datim id-em
    */
    
    public function dohvati($por_id)    
    {
        $por_id = \UUID::codeId($por_id);
        $row = $this->find($por_id);
        
        return $this->decodeRecord($row);
    }
    
    //------------------------------------------------
    /** public function imaPopust($por_id){...}
    // Proverava da li data porudzbina ima popust
    */
    
    public function imaPopust($por_id)
    {
        $por = $this->find($por_id);
        if ($por > 0) {
            return true;
        }
        return false;
    }

    //------------------------------------------------
    /**public function decodeRecord($row){...}
    //Dekodovanje jednog rekorda
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
    //Dekodovanje nizova podataka
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