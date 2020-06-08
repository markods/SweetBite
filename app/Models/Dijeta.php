<?php namespace App\Models;
// 2020-05-15 v0.1 Filip Lucic 0188/2017

/**
    
 * Dijeta predstavlja tip dijete koji se nalazi u bazi podataka.
 * 
 * @version v1.0
 * 

 * 
 *  */



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
    
    /**
     * Funkcija dohvata konkretnu dijetu na osnovu prosledjenog identifikatora
     * 
     * 
     * @param string $id Identifikator dijete koja se dohvata
     * 
     * @return object Zeljena dijeta se dohvata iz baze podataka
     * 
     * 
     *      */
    
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
    /** public function decodeRecord($row){...}
     * Dekodovanje sve kljuceve unutar jednog rekorda
     * 
     * @param object $row Objekat koji je vratila baza
     * 
     * @return object Primljeni objekat sa dekodovanim kljucevima
     */
    public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->dijeta_id = \UUID::decodeId($row->dijeta_id);
        return $row;  
    }
    
    //------------------------------------------------
    /** public function decodeArray($finds){...}
     * Dekodovanje nizova podataka
     * 
     * @param array $finds Niz objekata koji je vratila baza
     * 
     * @return array Primljeni niz sa dekodovanim kljucevima
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