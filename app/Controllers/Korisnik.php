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
          $proveraEmail=$this->request->getVar('email');
          if(!filter_var($proveraEmail,FILTER_VALIDATE_EMAIL)){
              return view('formati');
          }
       
        $email=$this->request->getVar('email');  
        $korisnikModel=new KorisnikModel();
        $dohvatiEmail=$korisnikModel->daLiPostojiEmail($email);
        
         //return redirect()->to(site_url("../public/Korisnik/index"));
        if($dohvatiEmail!=null){
            //znaci da taj korisnik ima nalog
            //treba da se vratimo na pocetak
            return redirect()->to(site_url("../public/Korisnik/index"));
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
           
         return redirect()->to(site_url("../public/Korisnik/index"));
       
    }
    

}
