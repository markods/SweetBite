<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17, verzija 0.2

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
   //proveri koja je povratna vrednost za insert
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['tipkor_id'] = $id;
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    
    //fja za update tipa korisnika
    //Ova fja mi za sada ne znaci nista, jer mi ne mozemo da menjamo naziv tipa korisnika ukoliko on ostane unique
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
    
    //brisanje reda iz tabele tipKorisnik
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    //dohvata naziv tipa korisnika po ID
    public function dohvatiNazivTipaKorisnika($id){
       $tipKorisnika=$this->find(\UUID::codeId($id));
       if( !isset($tipKorisnika) ) return null;
       return $tipKorisnika->tipkor_naziv;
    }
    
    //dohvata id tipa korisnika po njegovom nazivu
    //Nazivi su: 'Menadzer', 'Kuvar', 'Admin', 'Korisnik'
    public function dohvatiIDTipaKorisnika($naziv){
        $korisnik=$this->where('tipkor_naziv', $naziv)->find();
        if( count($korisnik) == 0 ) return null;
        return \UUID::decodeId($korisnik[0]->tipkor_id);
    }
}


