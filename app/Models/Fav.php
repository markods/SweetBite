<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17, verzija 0.2

class Fav extends Model
{
    protected $table      = 'fav';
    protected $primaryKey = 'fav_id';
    protected $returnType     = 'object';
    protected $allowedFields = ['fav_id','fav_kor_id', 'fav_jelo_id'];

    protected $validationRules    = [
                    'fav_kor_id'   => 'trim|required',
                    'fav_jelo_id' => 'trim|required'
            ];
    protected $validationMessages = [
                'fav_kor_id' => ['required' => 'Id korisnika je obavezan'],
                'fav_jelo_id' => ['required' => 'Id jela je obavezno']
            ];
    
    protected $skipValidation = false;
    protected $updatedField='';
       
    //proveri koja je povratna vrednost za insert
    public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['fav_id'] = $id;
        if (array_key_exists('fav_kor_id', $data)) {
            $data['fav_kor_id'] = \UUID::codeId($data['fav_kor_id']);
        }
        if (array_key_exists('fav_jelo_id', $data)) {
            $data['fav_jelo_id'] = \UUID::codeId($data['fav_jelo_id']);
        }
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    //update favorita modela
    //OVO NISAM JOS ISTESTIRALA
    public function update($id=NULL, $data=NULL):bool 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('fav_kor_id', $data)) {
            $data['fav_kor_id'] = \UUID::codeId($data['fav_kor_id']);
        }
        if (array_key_exists('fav_jelo_id', $data)){
            $data['fav_jelo_id'] = \UUID::codeId($data['fav_jelo_id']);
        }
        if(parent::update($id, $data) === false){
            return false;
        }
        return true;
    }
    
    //brisanje iz tabela favoriti
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    //dohvata ceo red tabele na osnovu primarnog kljuca, za sad nema neku primenu
    public function dohvatiFavorit($id){
        $id = \UUID::codeId($id);
        $row = $this->find($id);
        return $this->decodeRecord($row);
    }
    
    //dohvata sve favorite odredjenog korisnika na osnovu njegovog id
      public function dohvatiFavoriteZaKorisnika($fav_kor_id){
          $kor_id=\UUID::codeId($fav_kor_id);
          $favorit= $this->where('fav_kor_id',$kor_id)->findAll();
         $favorit= $this->decodeArray($favorit);
          //return $favorit[0]->fav_jelo_id;
         return $favorit;
    }
    
    //sluzi za dekodovanje, jer imamo strane kljuceve
      public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->fav_id = \UUID::decodeId($row->fav_id);
        $row->fav_kor_id = \UUID::decodeId($row->fav_kor_id);
        $row->fav_jelo_id = \UUID::decodeId($row->fav_jelo_id);
        return $row;  
    }
    
    //dekodovanje celog niza objekata
      public function decodeArray($finds)
    {
        //dekodujemo sve kljuceve
        for ($i = 0; $i < count($finds); $i++) {
            $finds[$i] = $this->decodeRecord($finds[$i]);
        }
        return $finds;  
    }

    //-----------------------------------------------------------------------
    
    //proverava da li je favorit tog korisnika
    public function jeFavorit($id_jela, $id_kor)
    {
        $jelo_id = \UUID::codeId($id_jela);
        $kor_id = \UUID::codeId($id_kor);
        $ima = $this->where('fav_jelo_id', $jelo_id)->where('fav_kor_id', $kor_id)->findAll();
    
        if (count($ima) > 0) {
            return true;
        }
        else {
            return false;
        }
    }
    
    //dohvata id odredjenog favorite
    public function idFavorita($id_jela, $id_kor)
    {
        $jelo_id = \UUID::codeId($id_jela);
        $kor_id = \UUID::codeId($id_kor);
        $ima = $this->where('fav_jelo_id', $jelo_id)->where('fav_kor_id', $kor_id)->findAll();
        
        return \UUID::decodeId($ima[0]->fav_id);
    }
}