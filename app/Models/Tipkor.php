<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * 2020-06-08 - Autor: Jovana Jankovic 0586/17, verzija 0.3
 * Tipkor Model sadrzi informacije o tipovima korisnika koji postoje u sistemu
 * Tipovi mogu biti: 'Menadzer', 'Kuvar', 'Admin', 'Korisnik'
 * 
 *  */

class Tipkor extends Model
{
    protected $table      = 'tipkor';
    protected $primaryKey = 'tipkor_id';
    protected $returnType     = 'object';
   //nisam dozvolila da mogu da se menjaju: tipkor_id
   //proveri jos uvek koja polja treba da budu allowedFields
    protected $allowedFields = ['tipkor_id','tipkor_naziv'];
    
     protected $validationRules    = [
                    'tipkor_naziv'   => 'trim|required|is_unique[tipkor.tipkor_naziv]'
            ];
    protected $validationMessages = [
                'tipkor_naziv' => ['required' => 'Naziv tipa korisnika je obavezan',
                    'is_unique'=>'Naziv tipa korisnika je jedinstven']
            ];
    
    protected $skipValidation     = false;
    protected $updatedField='';
   

         /** public function insert($data=NULL, $returnID=true) {...}
         * Kreiranje nove instance Tipa korisnika
         * 
         * @param Array $data
         * @param bool $returnID
         * @return String vraca dekodovanu vrednost novo-insertovanog id tipa korisnika
         */
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['tipkor_id'] = $id;
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    
   /** public function update($id=NULL, $data=NULL):bool {...}
     * Update postojeceg korisnika
     * 
     * @param string $id id konkretnog tipa korisnika za koji zelimo da uradimo azuriranje u bazi 
     * @param Array $data niz informacija o tipu korisnika koji ce nam sluziti za update
     * @return bool
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
    
    /**public function delete($id=NULL, $purge=false) {...}
     * Brisanje tipa korisnika iz baze
     * 
     * @param string $id id tipa korisnika kojeg zelimo da obrisemo iz baze
     * @param bool $purge
     * @return void
     */
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    /**public function dohvatiNazivTipaKorisnika($id){...}
     * Dohvata se naziv tipa korisnika na osnovu id tipa korisnika
     * Nazivi su: 'Menadzer', 'Kuvar', 'Admin', 'Korisnik'
     *  
     * @param string $id id tipa korisnika
     * @return string naziv tipa korisnika 
     */
    public function dohvatiNazivTipaKorisnika($id){
       $tipKorisnika=$this->find(\UUID::codeId($id));
       if( !isset($tipKorisnika) ) return null;
       return $tipKorisnika->tipkor_naziv;
    }
    
    /** public function dohvatiIDTipaKorisnika($naziv){...}
     * Dohvata se id tipa korisnika na osnovu naziva tipa korisnika
     * Nazivi koji mogu biti prosledjeni su: 'Menadzer', 'Kuvar', 'Admin', 'Korisnik'
     * 
     * @param string $naziv naziv tipa korisnika
     * @return string id tipa korisnika 
     */
    public function dohvatiIDTipaKorisnika($naziv){
        $korisnik=$this->where('tipkor_naziv', $naziv)->find();
        if( count($korisnik) == 0 ) return null;
        return \UUID::decodeId($korisnik[0]->tipkor_id);
    }
}


