<?php namespace App\Models;
// 2020-05-14 v0.2 Jovana Pavic 2017

/*
  !!!   Pre pristupanja bazi svaki id treba kodirati sa |||
  !!!           \UUID::codeId($id);                     !!!
 */

use CodeIgniter\Model;

class Povod extends Model
{
    //kolone u tabeli: 'povod_id', 'povod'
    protected $table      = 'povod';
    protected $primaryKey = 'povod_id';

    protected $returnType     = 'object';
    //protected $useSoftDeletes = true;
        //kada se red obrise postavi se polje deleted_at
        //(treba i ono da se doda onda)
        //i ne vraca se find metodama
        
    protected $allowedFields = ['povod_id', 'povod_opis'];

    protected $validationRules = [
                'povod_opis' => 'trim|required|is_unique[povod.povod_opis]'];
    protected $validationMessages = [
                'povod_opis'=>[
                        'required' => 'Opis povoda je obavezan', 
                        'is_unique' => 'Opis povoda mora biti jedinstven'  
                        ]
                ];
    
    //----------------------------------------------------------------------
    
    //override osnovnih metoda tako da prikazuju greske
    //dobro za razvojnu fazu
    
    //-----------------------------------------------
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    //preporucljivo koristiti insert i update jer insert vraca id
    
    /*public function save($data):bool 
     * {
        $id = \UUIDLib::generateId();
        //if(!array_key_exists('povod_id', $data)){
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
    //ako je neuspesno vraca false
    //ako je uspesno vraca id
    
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();
        $data['povod_id'] = $id;
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
    //u svakom slucaju baca gresku
    
    public function delete($id=NULL, $purge=false) 
    {
       throw new Exception('Not implemented');
    }

    //-----------------------------------------------
    //dohvata id povoda na osnovu opisa    
    //ako se taj string nalazi u vise elemenata
    //vraca tacno onaj koji je trazen
    //ako ne postoji red sa tim opisom vraca null
    
    public function povodId($povod_opis)
    {
        $finds = $this->like('povod_opis', $povod_opis)->findAll();
        for ($i = 0; $i < count($finds); $i++) {
            $row = $finds[$i];
            if ($row->povod_opis == $povod_opis) {
                return \UUID::decodeId($row->povod_id);
            }
        }
        return null;
    }
    
    //------------------------------------------------
    //Dohvata povod sa datim id-em
    
    public function dohvati($povod_id)    
    {
        $povod_id = \UUID::codeId($povod_id);
        return $this->find($povod_id);
    }
}
