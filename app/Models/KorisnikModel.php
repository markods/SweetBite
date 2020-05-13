<?php namespace App\Models;

use CodeIgniter\Model;

//Autor: Jovana Jankovic 0586/17

class KorisnikModel extends Model
{
    protected $table      = 'kor';
    protected $primaryKey = 'kor_id';
    protected $returnType = 'object';

    //nisam dozvolila da mogu da se menjaju kor_id, kor_pwdhash, kor_datkre, kor_dauklanj
    protected $allowedFields = ['kor_id','kor_naziv', 
        'kor_email','kor_tel','kor_tipkor_id','kor_pwdhash','kor_datkre','kor_datuklanj'];
  
    protected $validationRules    = [
                    'kor_naziv'   => 'trim|required',
                    'kor_email' => 'trim|required|is_unique[kor.kor_email]',
                    'kor_tel' => 'trim|required',
                    'kor_pwdhash'   => 'trim|required|is_unique[kor.kor_pwdhash]',
                    'kor_tipkor_id'   => 'trim|required'
            ];
    
    protected $validationMessages = [
                'kor_naziv' => ['required' => 'Ime korisnika je obavezno'],
                'kor_email' => ['required' => 'Id povoda je obavezan','is_unique'=>'Email korisnika mora biti jedinstven'],
                'kor_tel' => ['required' => 'Broj telefona je obavezno polje'],
                'kor_pwdhash'   => ['required' => 'Za kada je obavezno','is_unique'=>'Password korisnika je jedinstven'],
                'kor_tipkor_id'=>['required'=>'Id tipa korisnika je obavezno polje']
            ];
    
   // protected $useTimestamps = true;
    //ovo mi nije bas najjasnije
    //protected $createdField  = 'kor_datkre';
   // protected $dateFormat = 'datetime';
    protected $skipValidation     = false;
    
   //proveri koja je povratna vrednost za insert
   /* public function insert($data=NULL, boolean $returnID=true) {
        $id = \UUIDLib::generateID();
        $data['kor_id'] = $id;
        if(parent::insert($data)===false){
             echo '<h3>Postoje greske u unosu podataka:</h3>';
             $errors = $this->errors();
            foreach ($errors as $field => $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        } 
       return $id;
    }*/
    
    //update za tabelu korisnik
   /* public function update($id = null, $data = null): bool {
        if(parent::update($id, $data)==false){
             echo '<h3>Postoje greske u unosu podataka:</h3>';
            $errors = $this->errors();
            foreach ($errors as $filed->$error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
    }*/
    
    
    //zabranili smo brisanje iz baze
    /*public function delete($id = null, boolean $purge = false) {
       throw new Exception("Ne mozete obrisati red");
    }*/
    
   //fja za dohvatanje korisnika, mada mi to ovde i ne treba
    public function dohvatiKorisnika($id){
        return $this->find($id);   
    }

   //ova fja moze da koristi administratoru za dohvatanje korisnika 
   //po prosledjenom id za tip koriznika
   public function dohvatiSveKorisnikePoTipuKorisnika($tipkor_id){
        return $this->where('kor_tipkor_id',$tipkor_id)->findAll();
   }
   
   //ova fja sluzi za proveru da li korisnik
   //sa unetim emailom i passwordom postoji u bazi
   public function dohvatiKorisnikaZaLogovanje($email, $lozinka){
   //proveri za password sta se s tim desava
       return $postoji=$this->where('kor_email',$email)->andWhere('kor_pwdhash',$lozinka)->find();
   }
   
   //fja potrebna za registraciju
   //neophodno je da fja vrati null kako bi se korisnik uspesno registrovao
   public function daLiPostojiEmail($email){
       return $this->where('kor_email',$email)->find();
   }
   
   
   
    // protected $useSoftDeletes = true;
    /*protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;*/
}