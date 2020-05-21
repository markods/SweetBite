<?php namespace App\Models;
// 2020-05-15 v0.1 Filip Lucic 0188/2017

use CodeIgniter\Model;

class Ukus extends Model {
        
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
        $row = $this->find($id);
        if ($row == null) return null;
        return $this->decodeRecord($row);
    }
    //dohvata id po nazivu
    public function dohvIdPoNazivu($naziv) {
        $ukus = $this->where('ukus_naziv', $naziv)->findAll();
        if (count($ukus) == 0) return null;
        return \UUID::decodeId($ukus[0]->ukus_id);
    }

    public function insert($data=NULL, $returnID=true) {
        $id = \UUID::generateId();        
        $data['ukus_id'] = $id;
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
        $row->ukus_id = \UUID::decodeId($row->ukus_id);
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