<?php namespace App\Models;
// 2020-05-20 v0.4 Jovana Pavic 2017/0099

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
        
    protected $allowedFields = [
                                'povod_id', 
                                'povod_opis'
                            ];

    protected $validationRules = [
                'povod_opis' => 'trim|required|is_unique[povod.povod_opis]'];
    protected $validationMessages = [
                'povod_opis'=>[
                        'required' => 'Opis povoda je obavezan', 
                        'is_unique' => 'Opis povoda mora biti jedinstven'  
                        ]
                ];
    
    //----------------------------------------------------------------------
    
    /*
    //override osnovnih metoda tako da prikazuju greske
    //dobro za razvojnu fazu
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    //preporucljivo koristiti insert i update jer insert vraca id
    */
    
    //-----------------------------------------------    
    /** public function insert($data=NULL,$returnID=true){...}
    //ako je neuspesno vraca false
    //ako je uspesno vraca id
    */
    
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
    /** public function update($id=NULL,$data=NULL):bool{...}
    //ako je uspesno vraca true, ako nije vraca false
    */
    
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
    /** public function delete($id=NULL,$purge=false){...}
    //ako je zabranjeno brisanje iz tabele    
    //u svakom slucaju baca gresku
    */
    
    public function delete($id=NULL, $purge=false) 
    {
       throw new Exception('Not implemented');
    }

    //-----------------------------------------------
    /** public function povodId($povod_opis){...}
    //dohvata id povoda na osnovu opisa    
    //ako se taj string nalazi u vise elemenata
    //vraca tacno onaj koji je trazen
    //ako ne postoji red sa tim opisom vraca null
    */
    
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
    
    //-----------------------------------------------
    /** public function povodOpis($povod_id){...}
    //dohvata opis povoda na osnovu id-a 
    //ako ne postoji red sa tim id-em vraca null
    */
    
    public function povodOpis($povod_id)
    {
        $povod_id = \UUID::codeId($povod_id);
        $find = $this->find($povod_id);
        if ($find == null) return null;
        return $find->povod_opis;
    }
    
    //------------------------------------------------
    /** public function dohvati($povod_id){...} 
    //Dohvata povod sa datim id-em
    */
    
    public function dohvati($povod_id)    
    {
        $povod_id = \UUID::codeId($povod_id);
        $row = $this->find($povod_id);
        $row->povod_id = \UUID::decodeId($row->povod_id);
        return $row;
    }
    
    //------------------------------------------------
    /** public function dohvati($povod_id){...} 
    // Dohvata povod sa datim id-em
    */
    
    public function sviPovodi()
    {
        $povodi = $this->findAll();
        if (count($povodi) == 0) return null;
        
        return $this->decodeArray($povodi);
    }
        
    //------------------------------------------------
    /**public function decodeRecord($row){...}
    // Dekodovanje jednog rekorda
    */
    
    public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->povod_id = \UUID::decodeId($row->povod_id);
        return $row;  
    }
    
    //------------------------------------------------
    /** public function decodeArray($finds){...}
    // Dekodovanje nizova podataka
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
