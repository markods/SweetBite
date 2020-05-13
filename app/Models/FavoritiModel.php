<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17

class FavoritiModel extends Model
{
    protected $table      = 'fav';
    protected $primaryKey = 'fav_id';
    protected $returnType     = 'object';
    protected $allowedFields = ['fav_id','fav_kor_id', 'fav_jelo_id'];

    protected $validationRules    = [
                    'fav_kor_id'   => 'trim|required',
                    'fav_jelo_id' => 'trim|required'
            ];
    protected $validationMessages = [
                'fav_kor_id' => ['required' => 'Id korisnika je obavezan'],
                'fav_jelo_id' => ['required' => 'Id jela je obavezno']
            ];
    
    protected $skipValidation = false;
       
    //proveri koja je povratna vrednost za insert
    public function insert($data = null, boolean $returnID = true) {
        $id = \UUIDLib::generateID();
        $data['fav_id'] = $id;
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
    
    //update za tabelu favoriti model
    public function update($id = null, $data = null): bool {
        if(parent::update($id, $data)==false){
             echo '<h3>Postoje greske u unosu podataka:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
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
    
    //dohvata sve favorite odredjenog korisnika
    public function dohvatiFavoriteZaKorisnika($kor_id){
      return  $this->where('fav_kor_id',$kor_id)->findAll();
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