<?php namespace App\Models;
 
use CodeIgniter\Model;
  

/*-------------------Ne radi zbog kompozitnog primarnog kljuca ------------*/

class StavkaModel extends Model
{
    //kolone u tabeli: stavka_por_id, stavka_jelo_id, stavka_kol
    //                  stavka_cenakom, stavka_datkre, stavka_datizrade
    protected $table      = 'stavka';
    protected $primaryKey = 'stavka_por_id';
        //u dokumentaciji kaze da mora 'stavka_por_id_stavka_jelo_id'
    protected $returnType     = 'object';
    protected $useSoftDeletes = true;
        //onda treba definisati i protected $deletedField
 
    protected $allowedFields = ['stavka_por_id', 'stavka_jelo_id', 
                'stavka_kol', 'stavka_cenakom', 'stavka_datizrade'];
 
    protected $useTimestamps = true;
    protected $createdField  = 'stavka_datkre';
    protected $dateFormat = 'datetime';
 
    protected $validationRules    = [
                    'stavka_por_id'  => 'required',
                    'stavka_jelo_id' => 'required',
                    'stavka_kol'     => 'required',
                    'stavka_cenakom' => 'required'
                ];
    protected $validationMessages = [
                'stavka_por_id'  => ['required' => 'Id porudzbine je obavezan'],
                'stavka_jelo_id' => ['required' => 'Id jela je obavezan'],
                'stavka_kol'     => ['required' => 'Kolicina jela je obavezna'],
                'stavka_cenakom' => ['required' => 'Cena po komadu je obavezna']
            ];
    protected $skipValidation     = false;

    //-----------------------------------------------------------------------
    
    //override osnovnih metoda tako da prikazuju greske
    
    //metoda save ne mora da se overrid-uje jer ona samo poziva
    //insert i update u zavisnosti od parametara
    /*public function save($data):bool 
    {
        $id = \UUIDLib::generateID();
        if(!array_key_exists('povod_id', $data)){
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
        //Pokusaj sa PDO objektom
        /*$conn = \DB::getInstanca();
        $row = $conn->prepare('INSERT INTO stavka (stavka_por_id, 
            stavka_jelo_id, stavka_kol, stavka_cenakom)
            VALUES (:po_id, :jelo_id, :kol, :cenakom');
        
        $date = 11;
        $row->execute([
            'po_id'=>$data['stavka_por_id'],
            'jelo_id' => $data['stavka_jelo_id'],
            'kol'     => $data['stavka_kol'],
            'cenakom' => $data['stavka_cenakom'],
                ]);
        
        return $conn->lastInsertId();
        */
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
       
}