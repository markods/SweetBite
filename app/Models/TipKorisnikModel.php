<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17

class TipKorisnikModel extends Model
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
   
   //proveri koja je povratna vrednost za insert
    public function insert($data = null, boolean $returnID = true) {
        $id = \UUIDLib::generateID();
        $data['tipkor_id'] = $id;
        if(parent::insert($data)===false){
             echo '<h3>Postoje greske u unosu podataka:</h3>';
             $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        } 
       return $id;
    }
    
    //update za tabelu korisnik
    public function update($id = null, $data = null): bool {
        if(parent::update($id, $data)==false){
            echo '<h3>Postoje greske u unosu podataka:</h3>';
            $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
    }
    
    //zabranili smo brisanje iz baze
    public function delete($id = null, boolean $purge = false) {
       throw new Exception("Ne mozete obrisati red");
    }
    
    //proveri da li moze
    public function dohvatiNazivTipaKorisnika($id){
       // $where="tipkor_id='$id'";
       //vraca ceo objekat tipa korisnika, pa cu da izvucem naziv sa $objekat->tipkor_naziv
        return $this->where('tipkor_id',$id);
    }

    // protected $useSoftDeletes = true;

    /*protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;*/
}