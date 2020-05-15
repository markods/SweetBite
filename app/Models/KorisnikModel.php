<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17, verzija 0.2

class KorisnikModel extends Model
{
    //tabela korisnik
    protected $table      = 'kor';
    protected $primaryKey = 'kor_id';
    protected $returnType = 'object';

    protected $allowedFields = ['kor_id','kor_naziv', 
        'kor_email','kor_tel','kor_tipkor_id','kor_pwdhash'];
  
    protected $validationRules    = [
                    'kor_naziv'   => 'trim|required',
                    'kor_email' => 'trim|required|is_unique[kor.kor_email]',
                    'kor_tel' => 'trim|required',
                    'kor_pwdhash'   => 'trim|required|is_unique[kor.kor_pwdhash]',
                    'kor_tipkor_id'   => 'trim|required'
            ];
    
    protected $validationMessages = [
                'kor_naziv' => ['required' => 'Ime korisnika je obavezno'],
                'kor_email' => ['required' => 'Email adresa je obavezno polje','is_unique'=>'Email korisnika mora biti jedinstven'],
                'kor_tel' => ['required' => 'Broj telefona je obavezno polje'],
                'kor_pwdhash'   => ['required' => 'Za kada je obavezno','is_unique'=>'Password korisnika je jedinstven'],
                'kor_tipkor_id'=>['required'=>'Id tipa korisnika je obavezno polje']
            ];
    
    protected $useTimestamps = true;
    protected $createdField  = 'kor_datkre';
    protected $dateFormat = 'datetime';
    protected $deletedField='kor_datuklanj';
    protected $skipValidation     = false;
    protected $updatedField='';
   
    //fja za insertovanje novog korisnika
     public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['kor_id'] = $id;
        if (array_key_exists('kor_tipkor_id', $data)) {
            $data['kor_tipkor_id'] = \UUID::codeId($data['kor_tipkor_id']);
        }
        if(parent::insert($data, $returnID) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    //fja za update postojeceg korisnika
    public function update($id=NULL, $data=NULL):bool 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('kor_tipkor_id', $data)) {
            $data['kor_tipkor_id'] = \UUID::codeId($data['kor_tipkor_id']);
        }
        if(parent::update($id, $data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
    }
    
    
    //fja za brisanje korisnika iz baze
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    
   //fja za dohvatanje korisnika na osnovu primarnog kljuca, podrazumevano prima dekodovanu vrednost
    public function dohvatiKorisnika($id){
       $id=\UUID::codeId($id);
        return $this->find($id);   
    }

   //ova fja moze da koristi administratoru za dohvatanje odredjenog tipa korisnika RADI
   public function dohvatiSveKorisnikePoTipuKorisnika($tipkor_id){
       $tipkor_id=\UUID::codeId($tipkor_id);
        $korisnici= $this->where('kor_tipkor_id',$tipkor_id)->findAll();
        $korisnici=$this->decodeArray($korisnici);
        return $korisnici;
   }
     
   //neophodno je da fja vrati null kako bi se korisnik uspesno registrovao RADI
   public function daLiPostojiEmail($email){
       $korisnik= $this->where('kor_email',$email)->findAll();
       $korisnik=$this->decodeArray($korisnik);
       return $korisnik;
   }
   
    //sluzi za dekodovanje, jer imamo strane kljuceve
      public function decodeRecord($row)
    {
        //dekodujemo sve kljuceve
        $row->kor_id = \UUID::decodeId($row->kor_id);
        $row->kor_tipkor_id = \UUID::decodeId($row->kor_tipkor_id);
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
   
}