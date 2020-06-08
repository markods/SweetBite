<?php namespace App\Models;
// 2020-05-15 v0.1 Filip Lucic 0188/2017


use CodeIgniter\Model;

/** Model koji komunicira sa bazom podataka kako bi se
 * dobijali podaci o tipovima jela.
    
 * @version 0.3

 * 
 *  */

class Tipjela extends Model {
    protected $table      = 'tipjela';
    protected $primaryKey = 'tipjela_id';
    protected $returnType = 'object';
    protected $allowedFields = ['tipjela_id','tipjela_naziv'];


    protected $validationRules    = [
                    'tipjela_naziv' => 'trim|required|is_unique[tipjela.tipjela_naziv]'];
    protected $validationMessages = ['tipjela_naziv' => ['required' => 'Naziv tipa jela je obavezan!']];
    protected $skipValidation = false;

   /**  public function dohvTip($id) {...}
    * Funkcija dohvata tip jela na osnovu prosledjenog identifikatora
    * 
    * @param string $id Jedinstveni identifikator tipa jela koji treba dohvatiti.
    * 
    * @return object Objekat tipa jela
    * 
    *     */
    public function dohvTip($id) {
        $id = \UUID::codeId($id);
        $row = $this->find($id);
        if (row == null) return null;
        return $this->decodeRecord($row);
    }
    /** public function dohvNazivTipa($id) {...}
    * Funkcija dohvata naziv tipa jela sa prosledjenim identifikatorom.
    * 
    * @param string $id Identifikator tipa jela ciji naziv treba dohvatiti.
    * 
    * @return string Naziv tipa jela.
    * 
    *     */
    public function dohvNazivTipa($id) {
        $id = \UUID::codeId($id);
        $naziv = $this->find($id);
        return $naziv->tipjela_naziv;
    }
    
    /**   public function dohvIdPoNazivu($naziv) {...}
     * Funkcija dohvata identifikator tipa jela ciji je naziv prosledjen.
     * 
     * @param string $naziv Naziv tipa jela ciji identifikator treba dohvatiti.
     * 
     * @return string Identifikator tipa jela.
     * 
     *      */
    public function dohvIdPoNazivu($naziv) {
        $tip_jela = $this->where('tipjela_naziv', $naziv)->findAll();
        return \UUID::decodeId($tip_jela[0]->tipjela_id);
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
        $data['tipjela_id'] = $id;
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
        $row->tipjela_id = \UUID::decodeId($row->tipjela_id);
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