<?php namespace App\Models;


use CodeIgniter\Model;

class UkusModel extends Model {
        protected $table      = 'ukus';
        protected $primaryKey = 'ukus_id';
        protected $returnType = 'object';
        protected $allowedFields = ['ukus_id', 'ukus_naziv'];
        
        protected $validationRules    = [
                        'ukus_naziv' => 'trim|required|is_unique[ukus.ukus_naziv]'
           ];
        protected $validationMessages = ['ukus_naziv' => ['required' => 'Naziv ukusa je obavezan!']];
        protected $skipValidation = false;
       
       //dohvata se tip, pa se u kontroleru dohvata naziv;
        public function dohvUkus($id) {
            $id = \UUID::codeId($id);
            return $this->find($id);
        }
       //dohvata id po nazivu
        public function dohvIdPoNazivu($naziv) {
            $ukus = $this->where('ukus_naziv', $naziv)->findAll();
            return \UUID::decodeId($ukus[0]->ukus_id);
        }
        
        public function insert($data=NULL, $returnID=true) {
            $id = \UUID::generateId();        
            $data['ukus_id'] = $id;
            if(parent::insert($data, $returnID) === false){
                echo '<h3>Greske u formi unosa:</h3>';
                $errors = $this->errors();
                foreach ($errors as $error) {
                    echo "<p>->$error</p>";   
                }
                return false;
            }
            return \UUID::decodeId($id);
        }
        
        
        public function delete($id=NULL, $purge=false) {
            if ($id != null) {
                $id = \UUID::codeId($id);
            }
            return parent::delete($id, $purge);
        }

    
    
    
}