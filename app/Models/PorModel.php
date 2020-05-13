<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    //Tu se upisuje korpa za ulogovanog korisnika, 
    //a datum porucivanja se naknadno popuni
    //por_datkre - datum kada je korpa kreirana
    //por_datpor - datum kada je kliknuto dugme poruci
    //kolone u tabeli: por_id, por_kor_id, por_naziv, por_povod_id,
    //                  por_br_osoba, por_za_dat, por_popust_proc,
    //                  por_datkre, por_datporuc, por_datodluke,
    //                  por_odluka, por_datizrade, por_datpreuz
    
    protected $table      = 'por';
    protected $primaryKey = 'por_id';
    
    protected $returnType     = 'object';
 
    protected $allowedFields = ['por_id', 'por_kor_id', 'por_naziv', 
                                'por_povod_id', 'por_br_osoba', 'por_za_dat', 
                                'por_popust_proc', 'por_datporuc', 
                                'por_datodluke', 'por_odluke',
                                'por_datizrade', 'por_datpreuz'];
        //koja polja smeju da se menjaju metodama modela
 
    protected $useTimestamps = true;
    protected $createdField  = 'por_datkre';
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
    //dobro za razvojnu fazu
    
    //-----------------------------------------------
    
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    /*public function save($data):bool 
    {
        $id = \UUIDLib::generateID();
        if(!array_key_exists('povod_id', $data)){
            $data['povod_id'] = $id;
        }
        return parent::save($data);
        if(parent::save($data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;    
    }*/
    
    //-----------------------------------------------
    
    public function insert($data=NULL, $returnID=true):bool 
    {
        $id = \UUIDLib::generateID();        
        $data['por_id'] = $id;
        if(parent::insert($data, $returnID) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return $id;
    }
    
    //-----------------------------------------------
        
    public function update($id=NULL, $data=NULL):bool 
    {
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
    
    //ako je zabranjeno brisanje iz tabele
    public function delete($id=NULL, $purge=false) 
    {
        throw new Exception('Not implemented');
    }
    
    //-----------------------------------------------
    //Dohvata sve porudzbine korisnika sa zadatim id-em
    //Potrebnoo za prikaz porudzbina korisnika
    
    public function porudzbineKorisnika($kor_id)
    {
        return $this->where('por_kor_id', $kor_id)->findAll();
    }
    
    //-----------------------------------------------
    //Dohvata neke porudzbine korisnika sa zadatim id-em
    //Potrebno za prikaz filtriranih porudzbina korisnika 
    //status: 0-na cekanju, 1-prihvacene, 2-odbijena, 
    //3-gotova, 4-pokupljena    
    
    public function filtriranePorudzbineKorisnika($kor_id, $status)
    {
        if($status == 0) {
            //nije doneta odluka
            return $this->where('por_kor_id', $kor_id)
                    ->andwhere('por_datodluke', null)->findAll();
        }
        else if($status == 1) {
            //prihvacena porudzbina
            return $this->where('por_kor_id', $kor_id)
                    ->andlike('por_odluka', 'accepted')->findAll();
        }
        else if($status == 2) {
            //odbijena porudzbina
            return $this->where('por_kor_id', $kor_id)
                    ->andlike('por_odluka', 'declined')->findAll();
        }
        else if($status == 3) {
            //gotova
            return $this->where('por_kor_id', $kor_id)
                    ->andwhere('por_datizrade', !null)->findAll();
        }
        else if($status == 4) {
            return $this->where('por_kor_id', $kor_id)
                    ->andwhere('por_datpreuz', !null)->findAll();
        }
        else
            return null;        
    }
    
}