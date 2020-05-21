<?php namespace App\Models;
// 2020-05-15 v0.1 Filip Lucic 0188/2017


use CodeIgniter\Model;

class Dijeta extends Model {
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
        $row = $this->find($id);
        if (row == null) return null;
        return $this->decodeRecord($row);
    }
   //direktno dohvata naziv
    public function dohvNazivDijete($id) {
       $id = \UUID::codeId($id);
       $naziv = $this->find($id);
       if ($naziv == null) return null;
       return $naziv->dijeta_naziv;
    }


    public function dohvIdPoNazivu($naziv) {
        $dijeta = $this->where('dijeta_naziv', $naziv)->findAll();
        return \UUID::decodeId($dijeta[0]->dijeta_id);
    }


    public function insert($data=NULL, $returnID=true) {
        $id = \UUID::generateId();        
        $data['dijeta_id'] = $id;
        if(parent::insert($data, $returnID) === false){
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

    //------------------------------------------------
    /**public function decodeRecord($row){...}
    // Dekodovanje jednog rekorda
    */
    
    public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->dijeta_id = \UUID::decodeId($row->dijeta_id);
        return $row;  
    }
    
    //------------------------------------------------
    /** public function decodeArray($finds){...}
    // Dekodovanje nizova podataka
    */
    
    public function decodeArray($finds)
    {
        //dekodujemo sve kljuceve
        for ($i = 0; $i < count($finds); $i++) {
            $finds[$i] = $this->decodeRecord($finds[$i]);
        }
        return $finds;  
    }
    
}