<?php namespace App\Controllers;
// 2020-05-16 v0.1 Jovana Pavic 2017/0099

//bilo bi super kada bi neki delovi funkcija:
//  loadAllUsers()
//  changePrivilages()
//  loadAccount()

use App\Models\KorisnikModel;
use App\Models\TipKorisnikModel;

class Admin extends Ulogovani
{
    public function index()
    {    
        echo view('templejt/templejt-html.php');
    }
    
    //-----------------------------------------------
    //dohvata sve korisnike i salje AJAX-om
    
    public function loadAllUsers()
    {        
        $korModel = new KorisnikModel();
        $tipModel = new TipKorisnikModel();
        $korisnici = $korModel->findAll();
        $kor_id = [];
        $kor_naziv = [];
        $kor_mail = [];
        $kor_datkre = [];
        $kor_tipkor = [];
        for ($i = 0; $i < count($korisnici); $i++) {
            $kor_id[$i] = \UUID::decodeId($korisnici[$i]->kor_id);
            $kor_naziv[$i] = $korisnici[$i]->kor_naziv;
            $kor_mail[$i] = $korisnici[$i]->kor_email;
            $kor_datkre[$i] = $korisnici[$i]->kor_datkre;
            
            $u = $tipModel->dohvatiNazivTipaKorisnika(\UUID::decodeId($korisnici[$i]->kor_tipkor_id));
            switch ($u){
                case "admin": $kor_tipkor[$i]= 0; break;
                case "manager":$kor_tipkor[$i] = 1; break;
                case "chef": $kor_tipkor[$i] = 2; break;
                case "user": $kor_tipkor[$i] = 3; break;
            }
        }
        $user = [
            'kor_id' => $kor_id,
            'kor_ime' => $kor_naziv,
            'kor_mail' => $kor_mail,
            'kor_datkre' => $kor_datkre,
            'kor_tipkor' => $kor_tipkor
        ];
        $this->sendAJAX($user);           
    }
    
    //-----------------------------------------------
    //uklanja nalog iz baze na zahtev AJAX-a
    
    public function removeAccount() 
    {
        $korModel = new KorisnikModel();
        $elemDelete = $this->receiveAJAX();
        $korModel->delete($elemDelete['kor_id']);
    }
    
    //-----------------------------------------------
    //menja privilegiju korisnika u bazi na onu koju je 
    //poslao AJAX
    
    public function changePrivileges() 
    {
        $tipMod = new TipKorisnikModel();
        $korMod = new KorisnikModel();
        
        $elemChange = $this->receiveAJAX();
        
        $tipkor_opis = '';
        switch ($elemChange['nova_priv']){
            case 0: $tipkor_opis = 'admin';
                break;
            case 1: $tipkor_opis = 'manager';
                break;
            case 2: $tipkor_opis = 'chef';
                break;
            case 3: $tipkor_opis = 'user';
        }
        $kor_tipkor_id = $tipMod->dohvatiIDTipaKorisnika($tipkor_opis);
        
        $korMod->update($elemChange['kor_id'], ['kor_tipkor_id' => $kor_tipkor_id]);
    }
    
    //-----------------------------------------------
    //dohvata korisnika po id-u koji dobije iz AJAX-a
    //i vraca js-u preko AJAX-a
    
    public function loadAccount() 
    {
        $korModel = new KorisnikModel();
        $tipModel = new TipKorisnikModel();
        
        $elemLoad = $this->receiveAJAX();
        
        $korisnik = $korModel->find(\UUID::codeId($elemLoad['kor_id']));
        $kor_tipkor = null;
        $kor_id = \UUID::decodeId($korisnik->kor_id);
        $kor_naziv = $korisnik->kor_naziv;
        $kor_mail = $korisnik->kor_email;
        $kor_datkre = $korisnik->kor_datkre;
            
        $u = $tipModel->dohvatiNazivTipaKorisnika(\UUID::decodeId($korisnik->kor_tipkor_id));
        switch ($u){
            case "admin": $kor_tipkor = 0; break;
            case "manager":$kor_tipkor = 1; break;
            case "chef": $kor_tipkor = 2; break;
            case "user": $kor_tipkor = 3; break;
        }
        $user = [
            'kor_id' => $kor_id,
            'kor_ime' => $kor_naziv,
            'kor_mail' => $kor_mail,
            'kor_datkre' => $kor_datkre,
            'kor_tipkor' => $kor_tipkor
        ];
        $this->sendAJAX($user);
    }
    
}
