<?php namespace App\Models;


use CodeIgniter\Model;

class DijetaModel extends Model {
        protected $table      = 'dijeta';
        protected $primaryKey = 'dijeta_id';
        protected $returnType = 'object';
        protected $allowedFields = ['dijeta_id', 'dijeta_naziv']; 
        protected $validationRules    = [
                        'dijeta_naziv' => 'trim|required|is_unique[dijeta.dijeta_naziv]'];
        protected $validationMessages = ['dijeta_naziv' => ['required' => 'Naziv dijete je obavezan!']];
        protected $skipValidation = false;
       
       //dohvata se tip, pa se u kontroleru dohvata naziv;
        public function dohvDijetu($id) {
            $id = \UUID::codeId($id);
            return $this->find($id);
        }
       //direktno dohvata naziv
        public function dohvNazivDijete($id) {
           $id = \UUID::codeId($id);
           $naziv = $this->find($id);
           return $naziv->dijeta_naziv;
        }
       
       
        public function dohvIdPoNazivu($naziv) {
            $dijeta = $this->where('dijeta_naziv', $naziv);
            return \UUID::decodeId($dijeta[0]->dijeta_id);
        }
                

        public function insert($data=NULL, $returnID=true) {
            $id = \UUID::generateId();        
            $data['dijeta_id'] = $id;
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