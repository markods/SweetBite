<?php namespace App\Models;
// 2020-05-20 v0.4 Jovana Pavic 2017/0099

/*
  !!!   Pre pristupanja bazi svaki id treba kodirati sa |||
  !!!           \UUID::codeId($id);                     !!!
 */

use CodeIgniter\Model;

/**
 * Povod - klasa model, koja sluzi za komunikaciju sa bazom
 *         dohvatanje, izmena i uklanjanje iz tabele Por
 * 
 * @version 0.4
 */
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
        $data['povod_id'] = $id;
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
       throw new Exception('Not implemented');
    }

    //-----------------------------------------------
    /** public function povodId($povod_opis){...}
     * Dohvata id povoda na osnovu opisa    
     *  ako se taj string nalazi u vise elemenata
     *  vraca tacno onaj koji je trazen
     * Ako ne postoji red sa tim opisom vraca null
     * 
     * @param string $povod_opis
     * 
     * @return string|null
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
     * Dohvata opis povoda na osnovu id-a 
     * Ako ne postoji red sa tim id-em vraca null
     * 
     * @param string $povod_id 
     * 
     * @return string|null
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
     * Dohvata povod sa datim id-em
     * 
     * @param string $povod_id 
     * 
     * @return object
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
     * Dohvata povod sa datim id-em
     * 
     * @param string $povod_id 
     * 
     * @return array|null
     */
    public function sviPovodi()
    {
        $povodi = $this->findAll();
        if (count($povodi) == 0) return null;
        
        return $this->decodeArray($povodi);
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
        $row->povod_id = \UUID::decodeId($row->povod_id);
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
