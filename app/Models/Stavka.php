<?php namespace App\Models;
// 2020-05-14 v0.2 Jovana Pavic 2017

/*
  !!!   Pre pristupanja bazi svaki id treba kodirati sa |||
  !!!           \UUID::codeId($id);                     !!!
 */
 
use CodeIgniter\Model;

class Stavka extends Model
{
    //kolone u tabeli: stavka_id, stavka_por_id, stavka_jelo_id, stavka_kol
    //                  stavka_cenakom, stavka_datkre, stavka_datizrade
    protected $table      = 'stavka';
    protected $primaryKey = 'stavka_id';
    
    protected $returnType     = 'object';
 
    protected $allowedFields = [
                                'stavka_id', 
                                'stavka_por_id', 
                                'stavka_jelo_id', 
                                'stavka_kol', 
                                'stavka_cenakom', 
                                'stavka_datizrade'
                            ];
 
    protected $useTimestamps = true;
    protected $createdField  = 'stavka_datkre';
    protected $updatedField  = '';
    protected $deletedField  = '';
    protected $dateFormat = 'datetime';
 
    protected $validationRules    = [
                    'stavka_por_id'  => 'required',
                    'stavka_jelo_id' => 'required',
                    'stavka_kol'     => 'required',
                    'stavka_cenakom' => 'required'
                ];
    protected $validationMessages = [
                'stavka_por_id'  => ['required' => 'Id porudzbine je obavezan'],
                'stavka_jelo_id' => ['required' => 'Id jela je obavezan'],
                'stavka_kol'     => ['required' => 'Kolicina jela je obavezna'],
                'stavka_cenakom' => ['required' => 'Cena po komadu je obavezna']
            ];
    protected $skipValidation     = false;

    //-----------------------------------------------------------------------
    
    //override osnovnih metoda tako da prikazuju greske
    //dobro za razvojnu fazu
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    //preporucljivo koristiti insert i update jer insert vraca id
        
    //-----------------------------------------------    
    /** public function insert($data=NULL,$returnID=true){...}
    //ako je neuspesno vraca false
    //ako je uspesno vraca id
    */
    
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['stavka_id'] = $id;
        if (array_key_exists('stavka_por_id', $data)) {
            $data['stavka_por_id'] = \UUID::codeId($data['stavka_por_id']);
        }
        if (array_key_exists('stavka_jelo_id', $data)) {
            $data['stavka_jelo_id'] = \UUID::codeId($data['stavka_jelo_id']);
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
    /** public function update($id=NULL,$data=NULL):bool{...}
    //ako je uspesno vraca true, ako nije vraca false
    */
    
    public function update($id=NULL, $data=NULL):bool 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('stavka_por_id', $data)) {
            $data['stavka_por_id'] = \UUID::codeId($data['stavka_por_id']);
        }
        if (array_key_exists('stavka_jelo_id', $data)){
            $data['stavka_jelo_id'] = \UUID::codeId($data['stavka_jelo_id']);
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
    /** public function napravljenaStavka($stavka_id){...}
    //Stavki sa datim id-em se postavlja 
    //datum izrade na trenutni datum i vreme
    */
    
    public function napravljenaStavka($stavka_id)
    {
        //ne radi se codeId jer ga radi update
        $this->update($stavka_id, ['stavka_datizrade' => date('Y-m-d H:i:s')]);
    }        
    
    //-----------------------------------------------
    /** public function dohvati($stavka_id){...}
    //Dohvata stavku sa datim id-em
    */
    
    public function dohvati($stavka_id)
    {
        $stavka_id = \UUID::codeId($stavka_id);
        $row = $this->find($stavka_id);
        
        return $this->decodeRecord($row);
    }
    
    //------------------------------------------------
    /** public function decodeRecord($row)
    //Dekodovanje jednog rekorda
    */
    
    public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->stavka_id = \UUID::decodeId($row->stavka_id);
        $row->stavka_por_id = \UUID::decodeId($row->stavka_por_id);
        $row->stavka_jelo_id = \UUID::decodeId($row->stavka_jelo_id);
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