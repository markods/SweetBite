<?php namespace App\Models;
// 2020-05-14 v0.2 Jovana Pavic 2017

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
                    'por_kor_id'   => 'trim|required',
                    'por_povod_id' => 'trim|required',
                    'por_br_osoba' => 'trim|required',
                    'por_za_dat'   => 'trim|required',
            ];
    protected $validationMessages = [
                'por_kor_id' => ['required' => 'Id korisnika je obavezan'],
                'por_povod_id' => ['required' => 'Id povoda je obavezan'],
                'por_br_osoba' => ['required' => 'Broj osoba je obavezan'],
                'por_za_dat'   => ['required' => 'Za kada je obavezno']
            ];
    protected $skipValidation     = false;

    
    //-----------------------------------------------------------------------
    
    //override osnovnih metoda tako da prikazuju greske
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    //preporucljivo koristiti insert i update jer insert vraca id
    //dobro za razvojnu fazu
    
    //-----------------------------------------------    
    //ako je neuspesno vraca false
    //ako je uspesno vraca id
    
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
    //ako je uspesno vraca true, ako nije vraca false
        
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
    
    public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    //-----------------------------------------------
    //Dohvata sve porudzbine korisnika sa zadatim id-em
    //Potrebnoo za prikaz porudzbina korisnika
    
    public function porudzbineKorisnika($kor_id)
    {
        $kor_id = \UUID::codeID($kor_id);
        $finds = $this->where('por_kor_id', $kor_id)->findAll();
           
        return $this->decodeArray($finds);
    }
    
    //-----------------------------------------------
    //Dohvata neke porudzbine korisnika sa zadatim id-em
    //Potrebno za prikaz filtriranih porudzbina korisnika 
    //status: 0-na cekanju, 1-prihvacene, 2-odbijena, 
    //3-gotova, 4-pokupljena    
    
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
    //Upisuje datum odluke i donesenu odluku
    //u porudzbinu sa datim id-em
    //odluka: 0-prihvacena, 1-odbijena
    
    public function donetaOdluka($por_id, $odluka)
    {
        //ne radi se codeId jer ga radi update
        $this->update($por_id, ['por_odluka' => $odluka, 
                                'por_datodluke' => date('Y-m-d H:i:s')
            ]);
    }    
    
    //------------------------------------------------
    //Dohvata porudzbinu sa datim id-em
    
    public function dohvati($por_id)    
    {
        $por_id = \UUID::codeId($por_id);
        $row = $this->find($por_id);
        
        return $this->decodeRecord($row);
    }
    
    //------------------------------------------------
    //Dekodovanje jednog rekorda
    
    public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->por_id = \UUID::decodeId($row->por_id);
        $row->por_kor_id = \UUID::decodeId($row->por_kor_id);
        $row->por_povod_id = \UUID::decodeId($row->por_povod_id);
        return $row;  
    }
    
    //------------------------------------------------
    //Dekodovanje nizova podataka
    
    public function decodeArray($finds)
    {
        //dekodujemo sve kljuceve
        for ($i = 0; $i < count($finds); $i++) {
            $finds[$i] = $this->decodeRecord($finds[$i]);
        }
        return $finds;  
    }
         
}