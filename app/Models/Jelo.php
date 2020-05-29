<?php namespace App\Models;

use CodeIgniter\Model;

/** Autor: Filip Lučić 2017/0188 */

class Jelo extends Model
{       
        protected $table      = 'jelo';
        protected $primaryKey = 'jelo_id';
        protected $returnType = 'object';
        protected $allowedFields = ['jelo_id','jelo_naziv', 'jelo_opis', 'jelo_slika', 'jelo_cena', 'jelo_masa', 'jelo_tipjela_id', 'jelo_ukus_id', 'jelo_dijeta_id', 'jelo_datsakriv'];
        
        protected $useSoftDeletes = true;
        protected $useTimestamps = true;
        protected $createdField  = 'jelo_datkre';
        protected $updatedField  = '';
        protected $deletedField  = 'jelo_datuklanj';
        protected $dateFormat = 'datetime';
        
        //videti trim za format slike i int/float/binary
        protected $validationRules    = [
                        'jelo_naziv' => 'trim|required',
                        'jelo_opis' => 'trim|required',
                        'jelo_slika'   => 'required',
                        'jelo_cena' => 'required',
                        'jelo_masa' => 'required',
                        'jelo_tipjela_id' => 'required',
                        'jelo_ukus_id' => 'required',
                        'jelo_dijeta_id' => 'required'                        
                ];
       protected $validationMessages = [
                   'jelo_naziv' => ['required' => 'Naziv jela je obavezan!'],
                   'jelo_opis' => ['required' => 'Opis jela je obavezan!'],
                   'jelo_slika' => ['required' => 'Slika jela je obavezna!'],
                   'jelo_cena'   => ['required' => 'Cena jela je obavezna!'],
                   'jelo_masa'   => ['required' => 'Masa jela je obavezna!'],
                   'jelo_tipjela_id'   => ['required' => 'Identifikator tipa jela je obavezan!'],
                   'jelo_ukus_id'   => ['required' => 'Identifikator ukusa jela je obavezan!'],
                   'jelo_dijeta_id'   => ['required' => 'Identifikator dijete je obavezan!']                   
               ];
        protected $skipValidation = false;
        
        
        /** Dohvata sve podatke iz tabele Jelo */
        public function dohvSve() {
            $jela = $this->findAll();
            $jela = $this->decodeArray($jela);
            return $jela;
        }
        
        public function dohvSveWithDel() {
            $jela = $this->withDeleted()->findAll();
            $jela = $this->decodeArray($jela);
            return $jela;
        }

        /** Dohvata sve podatke na osnovu id iz tabele Jelo */
        public function dohvPoId($id) {
            $id = \UUID::codeId($id);
            return $this->decodeRecord($this->find($id));
        }

        /** Dohvata jelo na osnovu njegovog naziva */
        public function dohvPoImenu($naziv_jela) {
            $jela = $this->where('jelo_naziv', $naziv_jela)->findAll();
            $jela = $this->decodeArray($jela);
            return $jela;
        }

        public function insert($data=NULL, $returnID=true) {
        $id = \UUID::generateID();        
        $data['jelo_id'] = $id;
        if (array_key_exists('jelo_tipjela_id', $data)) {
            $data['jelo_tipjela_id'] = \UUID::codeId($data['jelo_tipjela_id']);
        }
        if (array_key_exists('jelo_ukus_id', $data)) {
            $data['jelo_ukus_id'] = \UUID::codeId($data['jelo_ukus_id']);
        }
         if (array_key_exists('jelo_dijeta_id', $data)) {
            $data['jelo_dijeta_id'] = \UUID::codeId($data['jelo_dijeta_id']);
        }
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
        }
       
        public function update($id=NULL, $data=NULL):bool {
            if ($id != null) {
            $id = \UUID::codeId($id);           
            }
             if (array_key_exists('jelo_tipjela_id', $data)) {
            $data['jelo_tipjela_id'] = \UUID::codeId($data['jelo_tipjela_id']);
            }
            if (array_key_exists('jelo_ukus_id', $data)) {
                $data['jelo_ukus_id'] = \UUID::codeId($data['jelo_ukus_id']);
            }
             if (array_key_exists('jelo_dijeta_id', $data)) {
                $data['jelo_dijeta_id'] = \UUID::codeId($data['jelo_dijeta_id']);
            }
            if(parent::update($id, $data) === false){
                return false;
            }
            return true;
        }
        
        /** Dohvata id jela na osnovu naziva jela */
        public function dohvatiId($naziv){
            $jelo=$this->where('jelo_naziv',$naziv)->findAll();
            $jelo=$this->decodeArray($jelo);
            return $jelo[0]->jelo_id;
        }
        
        public function delete($id=NULL, $purge=false) {
            if ($id != null) {
                $id = \UUID::codeId($id);
            }
            return parent::delete($id, $purge);
        }
        
        public function decodeArray($found) {
            for ($i = 0; $i < count($found); $i++) {
                $found[$i] = $this->decodeRecord($found[$i]);
            }
            return $found;  
        }
        
         public function decodeRecord($row) {
            $row->jelo_id = \UUID::decodeId($row->jelo_id);
            $row->jelo_tipjela_id = \UUID::decodeId($row->jelo_tipjela_id);
            $row->jelo_ukus_id = \UUID::decodeId($row->jelo_ukus_id);
            $row->jelo_dijeta_id = \UUID::decodeId($row->jelo_dijeta_id);
            return $row;  
        }
        
        /** Autor: Jovana Jankovic 0586/17 - Dohvata naziv jela na osnovu id jela */
        public function dohvatiNazivJela($id){
            $id=\UUID::codeId($id);
           $jelo=$this->where('jelo_id',$id)->withDeleted()->findAll();
           $jelo=$this->decodeArray($jelo);
           return $jelo[0]->jelo_naziv;
        }
        
        /** Autor: Jovana Jankovic 0586/17 - Dohvata masu jela na osnovu id jela */
        public function dohvatiMasu($id){
            $id=\UUID::codeId($id);
            $jelo=$this->where('jelo_id',$id)->withDeleted()->findAll();
            $jelo=$this->decodeArray($jelo);
           return $jelo[0]->jelo_masa;
        }
         
        public function pretragaPoParametrima() {
            
        }

    /** public function dohvatiSliku($id){...}
    // Dohvata sliku za odgovarajuci id
    */
    public function dohvatiSliku($id) 
    {
        $id = \UUID::codeId($id);
        $jelo = $this->find($id);
        if ($jelo == null) return null;
        return $jelo->jelo_slika;
    }
}
