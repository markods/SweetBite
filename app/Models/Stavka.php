<?php namespace App\Models;
// 2020-05-17 v0.4 Jovana Pavic 2017/0099

/*
  !!!   Pre pristupanja bazi svaki id treba kodirati sa |||
  !!!           \UUID::codeId($id);                     !!!
 */
 
use CodeIgniter\Model;

class Stavka extends Model
{
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
    
    /*
    // Metoda save ne mora da se overrid-uje jer ona samo poziva
    //  insert i update u zavisnosti od parametara
    // Preporucljivo koristiti insert i update jer insert vraca id
    */
    
    //-----------------------------------------------    
    /** public function insert($data=NULL,$returnID=true){...}
    // Ako je neuspesno vraca false
    // Ako je uspesno vraca id
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
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    //-----------------------------------------------
    /** public function update($id=NULL,$data=NULL):bool{...}
    // Ako je uspesno vraca true, ako nije vraca false
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
            return false;
        }
        return true;
    }
    
    //-----------------------------------------------
    /** public function delete($id=NULL,$purge=false){...} 
    // Dozvoljeno je brisanje, ali je potrebno prebaciti 
    //  kljuc u odgovarajuci format
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
    // Stavki sa datim id-em se postavlja 
    //  datum izrade na trenutni datum i vreme
    */
    
    public function napravljenaStavka($stavka_id)
    {
        //ne radi se codeId jer ga radi update
        $this->update($stavka_id, ['stavka_datizrade' => date('Y-m-d H:i:s')]);
    }        
    
    //-----------------------------------------------
    /** public function nijeNapravljenaStavka($stavka_id){...}
    // Stavki sa datim id-em se uklanja datum izrade 
    */
    
    public function nijeNapravljenaStavka($stavka_id)
    {
        //ne radi se codeId jer ga radi update
        $this->update($stavka_id, ['stavka_datizrade' => null]);
    }        
    
    //-----------------------------------------------
    /** public function dohvati($stavka_id){...}
    // Dohvata stavku sa datim id-em
    */
    
    public function dohvati($stavka_id)
    {
        $stavka_id = \UUID::codeId($stavka_id);
        $row = $this->find($stavka_id);
        
        return $this->decodeRecord($row);
    }
    
    //-----------------------------------------------
    /** public function stavkaJelaIzPor($id_jela,$idPor){...}
    // Dohvata stavku datog jela iz date porudzbine
    */
    
    public function stavkaJelaIzPor($id_jela, $id_por)
    {
        $id_jela = \UUID::codeId($id_jela);
        $id_por = \UUID::codeId($id_por);
        
        $finds = $this->where('stavka_por_id', $id_por)->
                where('stavka_jelo_id', $id_jela)->findAll();
        
        if (count($finds) > 0){
            return \UUID::decodeId($finds[0]->stavka_id);
        }
        else{
            return null;
        }
    }
    
    //-----------------------------------------------
    /** Autor: Jovana Jankovic 0586/17 - Dohvata sve stavke koje su vezane za konkretnu porudzbinu */
    public function dohvatiStavke($id_por){
        $id_por=\UUID::codeId($id_por);
        $stavke=$this->where('stavka_por_id',$id_por)->findAll();
        $stavke=$this->decodeArray($stavke);
        return $stavke;
    }
    
    //------------------------------------------------
    /** public function kolicinaJela($stavka_id){...}
    // Dohvata kolicinu jela iz date stavke
    */
    
    public function kolicinaJela($stavka_id)
    {
        $stavka_id =\UUID::codeId($stavka_id); 
        $finds = $this->find($stavka_id);
        
        return $finds->stavka_kol;            
    }
    
    //------------------------------------------------
    /** public function sveIzPor($por_id){...}
    // Dohvata sve stavke iz odredjene porudzbine
    */
    
    public function sveIzPor($por_id)
    {
        $por_id = \UUID::codeId($por_id);
        $stavke = $this->where('stavka_por_id', $por_id)->findAll();
        return $this->decodeArray($stavke);        
    }
     
    //------------------------------------------------
    /** public function decodeRecord($row)
    // Dekodovanje jednog rekorda
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