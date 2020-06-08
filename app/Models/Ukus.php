<?php namespace App\Models;
// 2020-05-15 v0.1 Filip Lucic 0188/2017

use CodeIgniter\Model;

/** Model koji komunicira sa bazom podataka kako bi se
 * dobijali podaci o razlicitim ukusima.
    
 * @version 0.3

 * 
 *  */

class Ukus extends Model {
        
    protected $table      = 'ukus';
    protected $primaryKey = 'ukus_id';
    protected $returnType = 'object';
    protected $allowedFields = ['ukus_id', 'ukus_naziv'];

    protected $validationRules    = [
                    'ukus_naziv' => 'trim|required|is_unique[ukus.ukus_naziv]'
                    ];
    protected $validationMessages = ['ukus_naziv' => ['required' => 'Naziv ukusa je obavezan!']];
    protected $skipValidation = false;

    /**   public function dohvUkus($id) {...}
     * Funkcija dohvata ukus na osnovu prosledjenog identifikatora.
     * 
     * @param string $id Identifikator ukusa
     * 
     * @return object Objekat ukusa, dohvacen iz baze podataka.
     *      */
    
    public function dohvUkus($id) {
        $id = \UUID::codeId($id);
        $row = $this->find($id);
        if ($row == null) return null;
        return $this->decodeRecord($row);
    }
    /**  public function dohvIdPoNazivu($naziv) {...}
     * Funkcija dohvata identifikator ukusa sa prosledjenim nazivom
     * 
     * @param string $naziv Naziv ukusa
     * 
     * @return object Objekat ukusa, dohvacen iz baze podataka.
     * 
     *      */
    public function dohvIdPoNazivu($naziv) {
        $ukus = $this->where('ukus_naziv', $naziv)->findAll();
        if (count($ukus) == 0) return null;
        return \UUID::decodeId($ukus[0]->ukus_id);
    }
    
    
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

    public function insert($data=NULL, $returnID=true) {
        $id = \UUID::generateId();        
        $data['ukus_id'] = $id;
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    
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

    public function delete($id=NULL, $purge=false) {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
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
        $row->ukus_id = \UUID::decodeId($row->ukus_id);
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