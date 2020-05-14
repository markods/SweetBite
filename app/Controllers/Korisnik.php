<?php namespace App\Controllers;
use App\Models\KorisnikModel;

//Autori: Jovana Jankovic 0586/17, Filip Lucic 0188/17

class Korisnik extends BaseController
{
    public function index()
    {
        return view('naslovna');
    }
    
    public function registracija(){
        
        /* if(!$this->validate([$this->request->getVar('ime')=>'required',
          $this->request->getVar('email')=>'required', $this->request->getVar('telefon')=>'required',
              $this->request->getVar('password')=>'required',$this->request->getVar('pon_password')=>'required'])){
                    return view('greske');
        }*/
        
        //provera da li su uneta sva polja iz forme za registraciju
        if($this->request->getVar('ime')=="" || $this->request->getVar('email')=="" || $this->request->getVar('telefon')==""||
          $this->request->getVar('password')=="" || $this->request->getVar('pon_password')==""){
            return view('greske');
         }
          
        //provera da li su uneti passwordi jednaki
          if($this->request->getVar('password')!=$this->request->getVar('pon_password')){
            return view('sifre');
          }
          
         //provera da li je email unet po ispravnom formatu
          //ne radi bas kako smo hteli, on ne izvrsi upit sto je dobro
          //ali mi ne pozove view
          $proveraEmail=$_POST['email'];
          if(!filter_var($proveraEmail,FILTER_VALIDATE_EMAIL)){
              return view('greske');
          }
          
       
        $email=$this->request->getVar('email');  
        $korisnikModel=new KorisnikModel();
        $dohvatiEmail=$korisnikModel->daLiPostojiEmail($email);
        
         //return redirect()->to(site_url("../public/Korisnik/index"));
        if($dohvatiEmail!=null){
            //znaci da taj korisnik ima nalog
            //treba da se vratimo na pocetak
            return redirect()->to(site_url("../Korisnik/index"));
        }
        
       //znaci da korisnik ne postoji, i moze da se uloguje
      /*  $data=['kor_naziv'=>$this->request->getVar('ime'),'kor_email'=>$this->request->getVar('email'),
            'kor_tel'=>$this->request->getVar('telefon'),'kor_pwdhash'=>$this->request->getVar('password'),
            'kor_tipkor_id'=>1,'kor_datuklanj'=>null];*/
       
         $korisnikModel->insert([
            'kor_naziv'=>$this->request->getVar('ime'),
            'kor_email'=>$this->request->getVar('email'),
            'kor_tel'=>$this->request->getVar('telefon'),
             'kor_pwdhash'=> $this->request->getVar('password'),
             'kor_tipkor_id'=> 1,
             'kor_datkre'=> "date_crea",
             'kor_datuklanj'=> null
        ]);
           
         return redirect()->to(site_url("../Korisnik/index"));
       
    }
    
    
    public function login() {
       // $email = $this->request->getVar('kor_email');
       // $password = $this->request->getVar('kor_password');
        
     //   $email=$_POST['kor_email'];
      //  $password=$_POST['kor_password'];
     
      $email=$_POST['email'];  
        
     //$email = $this->input->post('email');

   // $this->form_validation->set_rules('email','EMAIL','trim|required|valid_email|is_unique[utilisateurs.email]');

    if(empty($email))
    {
        echo "Niste uneli email";
    }
    
        //$email=$_POST['email'];
        //$password=$_POST['password'];
        
        /*if(empty($email))
        
         /*    return view("greske");
        
        if(empty($password)){
            return view('sifre');
        }*/
        
        /*if(empty($email)){
           return "Niste uneli email";
         
        }*/
        
        
            
      /*  if(strlen($password)===0 ||strlen($email)===0) 
        {//provera da li je uneta sifra u polje
            return view("sifre");*/
//        if($email=="")     //provera da li je unet mejl u polje
//            return view ("greske");
    
else{    
        $model = new KorisnikModel(); //kreiram model kako bih dohvatao podatke iz baze
        $korisnik = $model->daLiPostojiEmail($email); //dohvatam korisnika samo na osnovu mejla
        if($korisnik == null)       //nije dohvacen korisnik
            return view('nema_korisnika');
        if($korisnik->kor_pwdhash!=$password)   //uneta je pogresna sifra
            return view ('wrong_password');
        
        
        $tip_korisnika = $korisnik->kor_tipkor_id;
        
        //Tip korisnika se dohvata iz baze, razlicit je za svaki tip,
        // treba se dogovoriti koja vrednost predstalvja koji tip korisnika!!!
        switch ($tip_korisnika) {
            
//            $_SESSION['email']=$email;
//            $_SESSION['password'] =$password;
            case '0':   
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
            case '1': 
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
                  
            case '2': 
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
            case '3': 
                        $this->session->set('email',$email);
                        $this->session->set('password', $password);
                        $this->session->set('tip_korisnika', $tip_korisnika);
                        return redirect()->to(site_url("../public/Korisnik/index"));
                      
                  
        }
        //dohvatiKorisnikaZaLogovanje
        //kor_pwdhash i kor_email
        
        
    }
    }

}


