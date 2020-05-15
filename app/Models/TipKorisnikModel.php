<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17, verzija 0.2

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
    protected $updatedField='';
   //proveri koja je povratna vrednost za insert
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['tipkor_id'] = $id;
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
    
    
    //fja za update tipa korisnika
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
    
    //brisanje reda iz tabele tipKorisnik
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    //proveri da li moze
    public function dohvatiNazivTipaKorisnika($id){
       // $where="tipkor_id='$id'";
       //vraca ceo objekat tipa korisnika, pa cu da izvucem naziv sa $objekat->tipkor_naziv
        return $this->where('tipkor_id',$id);
    }
}