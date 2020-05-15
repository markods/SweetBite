<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17, verzija 0.2

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
    protected $updatedField='';
       
    //proveri koja je povratna vrednost za insert
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['fav_id'] = $id;
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
    
    //update favorita modela
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
    
    //brisanje iz tabela favoriti
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    //dohvata sve favorite odredjenog korisnika
    public function dohvatiFavoriteZaKorisnika($kor_id){
      return  $this->where('fav_kor_id',$kor_id)->findAll();
    }

}