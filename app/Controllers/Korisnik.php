<?php namespace App\Controllers;
use App\Models\KorisnikModel;
// Jovana Jankovic 0586/17, Filip Lucic 0188/17


class Korisnik extends Ulogovani
{
    public function index()
    {
        return view('test');
    }
    
    public function registracija(){
         
        //provera da li su uneta sva polja iz forme za registraciju
        if($this->request->getVar('ime')==="" || $this->request->getVar('email')==="" || $this->request->getVar('telefon')===""||
          $this->request->getVar('password')==="" || $this->request->getVar('pon_password')===""){
           $_SESSION['nisu_uneta_sva_polja']="Nisu uneta sva polja!";
            //return view('greske');
             return redirect()->to(site_url("../Korisnik/index"));
         }
          
        //provera da li je korektno potvrdjena sifra u formi za registraciju
          if($this->request->getVar('password')!==$this->request->getVar('pon_password')){
             $_SESSION['nisu_iste_sifre']="Lozinke nisu iste";
          //  return view('sifre');
              return redirect()->to(site_url("../Korisnik/index"));
          }
          
         //Proverava format email adrese
          $proveraEmail=$this->request->getVar('email');
          if(!filter_var($proveraEmail,FILTER_VALIDATE_EMAIL)){
             $_SESSION['neispravan_email']="Niste uneli ispravan mail po formatu";
            return redirect()->to(site_url("../Korisnik/index"));
          }
          
          //provera da li su unete cifre za telefon, da neko ne unese slova npr
          $telefon=$this->request->getVar('telefon');
          if(is_numeric($telefon)===false){
           $_SESSION['neispravan_telefon']="Niste uneli ispravan telefon";
            return redirect()->to(site_url("../Korisnik/index"));
          }
          
        $email=$this->request->getVar('email');  
        $korisnikModel=new KorisnikModel();
        
        $dohvatiEmail=$korisnikModel->daLiPostojiEmail($email);
        
        //proveravamo da li je taj korisnik vec registrovan
        if($dohvatiEmail!=null){
            $this->session->set('korisnik_postoji',"Ovaj korisnik je vec registrovan");
            return redirect()->to(site_url("../Korisnik/index"));
        }
        
        //dohvatanje passworda koji treba da se hashira
        $pass=$this->request->getVar('password');
        $noviPassword=password_hash($pass,PASSWORD_DEFAULT);
        
        //ubacivanje novog korisnika u bazu
        $id= $korisnikModel->insert(
        [
             'kor_naziv'=>$this->request->getVar('ime'),
             'kor_email'=>$this->request->getVar('email'),
             'kor_tel'=>$this->request->getVar('telefon'),
             'kor_pwdhash'=>$noviPassword,
             'kor_tipkor_id'=> \UUID::decodeId(\UUID::generateId()),
             'kor_datkre'=> date('Y-m-d H:i:s'),
        ]);
         
        //vracamo se na pocetak sajta
         return redirect()->to(site_url("../Korisnik/index"));
       
    }
    
    public function login() { 
                
        //dohvatamo unesena polja iz forme
        $email=$_POST['kor_email'];
        $password=$_POST['kor_password'];

        if(empty($email))
        {
          $_SESSION['pogresan_email_login']="Niste uneli email";
          return redirect()->to(site_url("../Korisnik/index"));
        }
    
        if(empty($password))
        {
          $_SESSION['pogresan_password_login']="Niste uneli password";
          return redirect()->to(site_url("../Korisnik/index"));
        }
        
        $model = new KorisnikModel(); //kreiram model kako bih dohvatao podatke iz baze
        $korisnik = $model->daLiPostojiEmail($email); //dohvatam korisnika samo na osnovu mejla
        if($korisnik == null){   
            //nije dohvacen korisnik
              $_SESSION['pogresan_korisnik_login']="Ovaj korisnik ne postoji";
             return redirect()->to(site_url("../Korisnik/index"));
             
        }
         
        if(password_verify($password, $korisnik[0]->kor_pwdhash)==false){
            //uneta je pogresna sifra
             $_SESSION['pogresan_password_login']="Niste uneli password";
             return view('greske.php');            
            // return redirect()->to(site_url("../Korisnik/index")); 
        }
        
        //ako smo do ovde stigli, korisnik se ulogovao
        //dohvatamo id tipa korisnika
        return view("uspesan_login");
        
        //id tipa korsinika bi trebalo da bude vrednost od 0-3
        $tip_korisnika =\UUID::decodeId($korisnik[0]->kor_tipkor_id);
        
        //dohvatanje kljuca i naziva ukusa
        $tipModel = new TipKorisnikModel();
        
        $tip_korisnika = $tipModel->dohvatiNazivTipaKorisnika($tip_korisnika);
        
        //Tip korisnika se dohvata iz baze, razlicit je za svaki tip,
        // treba se dogovoriti koja vrednost predstalvja koji tip korisnika!!!
        switch ($tip_korisnika) {
            
            case 'musterija':   
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
            case 'kuvar': 
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
                  
            case 'menadzer': 
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
            case 'administrator': 
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
                  
        }
        //dohvatiKorisnikaZaLogovanje
        //kor_pwdhash i kor_email        
    }
}



