<?php namespace App\Models;

use CodeIgniter\Model;

class PovodModel extends Model
{
    //kolone u tabeli: 'povod_id', 'povod'
    protected $table      = 'povod';
    protected $primaryKey = 'povod_id';

    protected $returnType     = 'object';
    //protected $useSoftDeletes = true;
        //kada se red obrise postavi se polje deleted_at
        //(treba i ono da se doda onda)
        //i ne vraca se find metodama
    
    protected $allowedFields = ['povod_id', 'povod_opis'];

    protected $validationRules = [
                'povod_opis' => 'trim|required|is_unique[povod.povod_opis]'];
    protected $validationMessages = [
                'povod_opis'=>[
                        'required' => 'Opis povoda je obavezan', 
                        'is_unique' => 'Opis povoda mora biti jedinstven'  
                        ]
                ];
    
    //----------------------------------------------------------------------
    
    //override osnovnih metoda tako da prikazuju greske
    //dobro za razvojnu fazu
    
    //-----------------------------------------------
    
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    
    /*public function save($data):bool 
     * {
        $id = \UUIDLib::generateID();
        //if(!array_key_exists('povod_id', $data)){
            $data['povod_id'] = $id;
        }
        return parent::save($data);
        if(parent::save($data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
        
    }*/
    
    //-----------------------------------------------
    
    public function insert($data=NULL, $returnID=true):bool 
    {
        $id = \UUIDLib::generateID();
        $data['povod_id'] = $id;
        if(parent::insert($data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return $id;
    }
    
    //-----------------------------------------------
        
    public function update($id=NULL, $data=NULL):bool 
    {
        if(parent::update($data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
    }
    
    //-----------------------------------------------
    //ako je zabranjeno brisanje iz tabele
    
    public function delete($id=NULL, $purge=false) 
    {
        throw new Exception('Not implemented');
    }

    //-----------------------------------------------
    //dohvata id povoda na osnovu opisa
    
    public function povodId($povod_opis)
    {
        $finds = $this->like('povod_opis', $povod_opis)->findAll();
        //moze biti podstring opisa        
        for ($i = 0; $i < count($finds); $i++) {
            $row = $finds[$i];
            if ($row['povod_opis'] == $povod_opis)
                return $row['povod_id'];
        }
    }
    
}
