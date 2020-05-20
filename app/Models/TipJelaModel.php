<?php namespace App\Models;
// 2020-05-15 v0.1 Filip Lucic 0188/2017


use CodeIgniter\Model;

class TipJelaModel extends Model {
    protected $table      = 'tipjela';
    protected $primaryKey = 'tipjela_id';
    protected $returnType = 'object';
    protected $allowedFields = ['tipjela_id','tipjela_naziv'];


    protected $validationRules    = [
                    'tipjela_naziv' => 'trim|required|is_unique[tipjela.tipjela_naziv]'];
    protected $validationMessages = ['tipjela_naziv' => ['required' => 'Naziv tipa jela je obavezan!']];
    protected $skipValidation = false;

   //dohvata se tip, pa se u kontroleru dohvata naziv;
    public function dohvTip($id) {
        $id = \UUID::codeId($id);
        $row = $this->find($id);
        if (row == null) return null;
        return $this->decodeRecord($row);
    }
    //direktno dohvata naziv
    public function dohvNazivTipa($id) {
        $id = \UUID::codeId($id);
        $naziv = $this->find($id);
        return $naziv->tipjela_naziv;
    }
    public function dohvIdPoNazivu($naziv) {
        $tip_jela = $this->where('tipjela_naziv', $naziv)->findAll();
        return \UUID::decodeId($tip_jela[0]->tipjela_id);
    }
    public function insert($data=NULL, $returnID=true) {
        $id = \UUID::generateId();        
        $data['tipjela_id'] = $id;
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
        $row->tipjela_id = \UUID::decodeId($row->tipjela_id);
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