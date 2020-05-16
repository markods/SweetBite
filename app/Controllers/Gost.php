<?php namespace App\Controllers;
use \App\Models\KorisnikModel;
use \App\Models\TipKorisnikModel;
// 2020-05-10 v0.0 Jovana Jankovic 2017/0586, Filip Lucic 2017/0188
// 2020-05-14 v0.1 Marko Stanojevic 2017/0081


/**
 * this is the default controller for the web application
 * it handles requests from users that aren't logged in
 */
class Gost extends BaseController
{
    /**
     * draw the client index page
     */
    public function index()
    {
        // set the client html to the template page, with the given parameters
        return view('templejt/templejt-html.php');
    }
    
    
    /**
     * create an account for the client
     */
    public function register()
    {
        // 
        $req = $this->receiveAJAX();

        // 
        $kor_naziv = $req['kor_naziv'] ?? "";
        $kor_email = $req['kor_email'] ?? "";
        $kor_tel   = $req['kor_tel'  ] ?? "";
        $kor_pwd   = $req['kor_pwd'  ] ?? "";
        
        // 
        if( !$this->validate([
             $kor_naziv => 'required|alpha_space|min_length[1] |max_length[64] ',
             $kor_email => 'required|valid_email|min_length[1] |max_length[128]',
             $kor_tel   => 'required|numeric    |min_length[8] |max_length[16] ',
             $kor_pwd   => 'required            |min_length[10]|max_length[64] ']) )
        {
            $this->sendAJAX(['err' => 'neispravno popunjena forma']);
            return;
        }
        
        // 
        $kor_pwdhash = password_hash($kor_pwd, PASSWORD_DEFAULT);
        unset($kor_pwd);
        
        
        // 
        $model_kor = new KorisnikModel();
        
        // 
        if( $model_kor->daLiPostojiEmail($kor_email) )
        {
            $this->sendAJAX(['err' => 'vec postoji email']);
            return;
        }

        //
        if( $model_kor->daLiPostojiPassword($kor_pwdhash) )
        {
            $this->sendAJAX(['err' => 'vec postoji password']);
            return;
        }
        
        // 
        $kor_tipkor_id = \UUID::decodeId(\UUID::generateId());   // TODO: popraviti
        $kor_datkre    =  date('Y-m-d H:i:s');
        
        // 
        $kor_id = $model_kor->insert( compact(
            $kor_naziv,
            $kor_email,
            $kor_tel,
            $kor_pwdhash,
            $kor_tipkor_id,
            $kor_datkre
        ));
        
        // 
        if( !isset($kor_id) )
        {
            $this->sendAJAX(['err' => 'greska prilikom ubacivanja korisnika u bazu']);
            return;
        }
        
        // 
        $this->session->set( compact( $kor_naziv, $kor_tipkor_id ) );
        
        // 
        $this->sendAJAX(['msg' => 'uspesna registracija']);
        return redirect()->to(base_url("Korisnik/index"));   // TODO: popraviti
    }
    
    
    /**
     * log the client into the system
     */
    public function login()
    {
        // 
        $req = $this->receiveAJAX();

        // 
        $kor_email = $req['kor_email'] ?? "";
        $kor_pwd   = $req['kor_pwd'  ] ?? "";
        
        // 
        if( !$this->validate([
             $kor_email => 'required|valid_email|min_length[1] |max_length[128]',
             $kor_pwd   => 'required            |min_length[10]|max_length[64] ']) )
        {
            $this->sendAJAX(['err' => 'neispravno popunjena forma']);
            return;
        }
        
        // 
        $kor_pwdhash = password_hash($kor_pwd, PASSWORD_DEFAULT);
        unset($kor_pwd);
        
        
        // 
        $model_kor = new KorisnikModel();
        $kor = $model_kor->dohvatiKorisnikaPrekoEmaila($kor_email);
        
        // 
        if( !isset($kor) )
        {
            $this->sendAJAX(['err' => 'ne postoji email']);
            return;
        }

        //
        if( $kor_pwdhash != $kor->kor_pwd_hash )
        {
            $this->sendAJAX(['err' => 'pogresan password']);
            return;
        }
        
        // 
        $this->session->set( compact( $kor->kor_id, $kor->kor_tipkor_id ) );
        
        
        $this->sendAJAX(['msg' => 'success']);
        return redirect()->to(base_url("Korisnik/index"));


        
        
        
        // TODO: dovrsiti
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
