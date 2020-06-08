<?php namespace App\Models;

use CodeIgniter\Model;

/**
 * 
 * 2020-06-08 - Autor: Jovana Jankovic 0586/17, verzija 0.3
 * Korisnik Model sadrzi sve neophodne informacije za korisnika
 * To je njegov primarni kljuc, ime i prezime, email adresa, kontakt telefon, password i tip korisnika kojem pripada
 * 
 */

class Kor extends Model
{
    //tabela korisnik
    protected $table      = 'kor';
    protected $primaryKey = 'kor_id';
    protected $returnType = 'object';
    
    protected $useSoftDeletes = true;
    
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
   
    /**public function insert($data=NULL, $returnID=true) {...}
     * Kreiranje nove instance Korisnika 
     * 
     * @param Array $data
     * @param bool $returnID
     * @return String vraca dekodovanu vrednost novo-insertovanog id korisnika
     */
     public function insert($data=NULL, $returnID=true) 
    {
        $id = \UUID::generateId();        
        $data['kor_id'] = $id;
        if (array_key_exists('kor_tipkor_id', $data)) {
            $data['kor_tipkor_id'] = \UUID::codeId($data['kor_tipkor_id']);
        }
        if(parent::insert($data, $returnID) === false){
            return false;
        }
        return \UUID::decodeId($id);
    }
    
    /**public function update($id=NULL, $data=NULL):bool {...}
     * Update postojeceg korisnika
     * 
     * @param string $id id konkretnog korisnika za kojeg zelimo da uradimo azuriranje u bazi 
     * @param Array $data niz informacija za korisnika
     * @return bool
     */
    public function update($id=NULL, $data=NULL):bool 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        if (array_key_exists('kor_tipkor_id', $data)) {
            $data['kor_tipkor_id'] = \UUID::codeId($data['kor_tipkor_id']);
        }
        if(parent::update($id, $data) === false){
            return false;
        }
        return true;
    }
    
    
    /**public function delete($id=NULL, $purge=false) {...}
     * Brisanje korisnika iz baze
     * 
     * @param string $id id korisnika kojeg zelimo da obrisemo iz baze
     * @param bool $purge
     * @return void
     */
     public function delete($id=NULL, $purge=false) 
    {
        if ($id != null) {
            $id = \UUID::codeId($id);
        }
        return parent::delete($id, $purge);
    }
    
    
   /** public function dohvatiKorisnika($id){...}
    * Dohvatanje korisnika na osnovu njegovog primarnog kljuca, podrazumevano funkcija prima dekodovanu vrednost
    * koja se pri ulasku u funkciju koduje, a zatim se sa kodovanom vrednoscu pretrazuje baza podataka.
    * 
    * @param string $id dohvata korisnika na osnovu njegovog primarnog kljuca u bazi
    * @return object dohvacen korisnik na osnovu id
    *     */
    public function dohvatiKorisnika($id){
       $korisnik = $this->find(\UUID::codeId($id));
       if($korisnik == null) return null;
       
       return $this->decodeRecord($korisnik);
       
       /*Izmenjen deo:
            if( count($korisnik) == 0 ) return null
            return $this->decodeRecord($korisnik[0]);
        jer je metoda tu pucala i zamenjen je sa:
            if($korisnik == null) return null;
            return $this->decodeRecord($korisnik);
        */
    }
   
   /**public function dohvatiKorisnikaPrekoEmaila($email){...}
    * Dohvatanje objekta korisnika na osnovu njegove email adrese
    * 
    * @param string $email email adresa korisnika
    * @return object dohvacen korisnik 
    */
   public function dohvatiKorisnikaPrekoEmaila($email){
       $korisnik = $this->where('kor_email', $email)->find();
       if( count($korisnik) == 0 ) return null;
       
       return $this->decodeRecord($korisnik[0]);
   }
   
   /**public function dohvatiIdNaOsnovuImena($ime){...}
    * Dohvatanje id korisnika na osnovu njegovog imena
    * 
    * @param string $ime ime korisnika
    * @return string id korisnika
    */ 
   public function dohvatiIdNaOsnovuImena($ime){
       $korisnik=$this->where('kor_naziv',$ime)->find();
       $korisnik=$this->decodeArray($korisnik);
       return $korisnik[0]->kor_id;
   }
   
   /**public function dohvatiImeNaOsnovuId($id){...}
    * Dohvatanje imena korisnika na osnovu id, sluzi kod funkcionalnosti za prikaz porudzbine
    * 
    * @param string $id dekodovana vrednost id za konkretnog korisnika
    * @return string ime korisnika
    */
   public function dohvatiImeNaOsnovuId($id){
       $id=\UUID::codeId($id);
       $korisnik=$this->find($id);
       return $korisnik->kor_naziv;
   }
  
   /**public function dohvatiBrojTelefona($id){...}
    * Dohvatanje broja telefona na osnovu id korisnika
    * 
    * @param string $id id korisnika
    * @return string broj telefona korisnika
    */
   public function dohvatiBrojTelefona($id){
        $id=\UUID::codeId($id);
       $korisnik=$this->find($id);
       return $korisnik->kor_tel;
   }
   
   /**public function dohvatiSveKorisnikePoTipuKorisnika($tipkor_id){...}
    * Koristi administratoru za dohvatanje odredjenog tipa korisnika
    * 
    * @param string $tipkor_id id tipa korisnika
    * @return Array niz svih korisnika koji su odredjenog tipa
    */
   public function dohvatiSveKorisnikePoTipuKorisnika($tipkor_id){
        $tipkor_id = \UUID::codeId($tipkor_id);
        $korisnici = $this->where('kor_tipkor_id',$tipkor_id)->findAll();
        $korisnici = $this->decodeArray($korisnici);
        return $korisnici;
   }
     
   /**public function daLiPostojiEmail($email){...}
    * Provera da li korisnik sa tim emailom postoji u bazi podataka
    * 
    * @param string $email
    * @return bool vraca true ukoliko nema korisnika sa prosledjenim emailom
    */
   public function daLiPostojiEmail($email){
       $korisnik = $this->where('kor_email', $email)->find();
       return ( count($korisnik) != 0 );
   }

    /** public function sviKorisnici(){...}
     * Dohvata sve korisnike iz baze 
     * 
     * @return array Niz objekata
     */
    public function sviKorisnici()
    {
       $finds = $this->findAll();
       if (count($finds) == 0) return null;
       
       return $this->decodeArray($finds);
    }
   
   /**public function decodeRecord($row){...}
    * Dekoduje vrednosti kljuceva iz jednog reda posto se u tom redu tabele nalaze kodovane vrednosti
    * U zadatku uvek radimo sa dekodovanim vrednostima, pa nam je ova funkcija zbog toga neophodna
    * 
    * @param Array $row jedan red iz tabele sa kodovanim vrednostima id
    * @return Array dekodovan jedan red iz tabele
    */
      public function decodeRecord($row)
    {
        if( !isset($row) ) return null;
        
        //dekodujemo sve kljuceve
        $row->kor_id = \UUID::decodeId($row->kor_id);
        $row->kor_tipkor_id = \UUID::decodeId($row->kor_tipkor_id);
        return $row;  
    }
    
   /** public function decodeArray($finds){...}
    * Dekoduje vrednosti kljuceva iz niza posto se u tom nizu nalaze kodovane vrednosti
    * U zadatku uvek radimo sa dekodovanim vrednostima, pa nam je ova funkcija zbog toga neophodna
    * 
    * @param Array $row niz sa kodovanim vrednostima id
    * @return Array dekodovan niz
    */
      public function decodeArray($finds)
    {
        if( !isset($finds) ) return null;
        
        //dekodujemo sve kljuceve
        for ($i = 0; $i < count($finds); $i++) {
            $finds[$i] = $this->decodeRecord($finds[$i]);
        }
        return $finds;  
    }
   
}