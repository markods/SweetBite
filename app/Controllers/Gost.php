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
        // receive the ajax data for registering
        $req = $this->receiveAJAX();

        // unpack the variables from the ajax request
        $kor_naziv = $req['kor_naziv'] ?? "";
        $kor_email = $req['kor_email'] ?? "";
        $kor_tel   = $req['kor_tel'  ] ?? "";
        $kor_pwd   = $req['kor_pwd'  ] ?? "";

        // if the sent form data is invalid, return an ajax error code response
        if( !$this->validate([
            'kor_naziv' => 'required|alpha_space|min_length[1]|max_length[64]',
            'kor_email' => 'required|valid_email|min_length[1]|max_length[128]',
            'kor_tel'   => 'required|numeric' .'|min_length[8]|max_length[16]',
            'kor_pwd'   => 'required'         .'|min_length[8]|max_length[64]']) )
        {
            $this->sendAJAX(['err' => 'form-invalid']);
            return;
        }
        
        // create models for the user and usertype
        $model_kor    = new KorisnikModel();
        $model_tipkor = new TipKorisnikModel();

        // initialize the remaining variables needed for the database record in table 'user'
        $kor_pwdhash   = password_hash($kor_pwd, PASSWORD_DEFAULT);  unset($kor_pwd);
        $kor_tipkor    = 'Korisnik';
        $kor_tipkor_id = $model_tipkor->dohvatiIDTipaKorisnika($kor_tipkor);
        $kor_datkre    = date('Y-m-d H:i:s');
        
        // if the email already exists in the database, return an error code
        if( $model_kor->daLiPostojiEmail($kor_email) )
        {
            $this->sendAJAX(['err' => 'email-exists']);
            return;
        }

        // if the password already exists in the database, return an error code
        if( $model_kor->daLiPostojiPassword($kor_pwdhash) )
        {
            $this->sendAJAX(['err' => 'password-exists']);
            return;
        }
        
        // try to insert a new user account record into the 'user' table
        $kor_id = $model_kor->insert( compact(
            $kor_naziv,
            $kor_email,
            $kor_tel,
            $kor_pwdhash,
            $kor_tipkor_id,
            $kor_datkre
        ));
        
        // if the insertion failed, return an error code
        if( !isset($kor_id) )
        {
            $this->sendAJAX(['err' => 'insert-failed']);
            return;
        }
        
        // set the session variables -- user id and the user type (in string form)
        $this->session->set( compact( $kor_id, $kor_tipkor ) );
        // return an ajax success code response to the user
        $this->sendAJAX(['suc' => 'register-success']);
        // redirect the user to their controller type
        return redirect()->to(base_url("{$kor_tipkor}/index"));
    }
    
    
    /**
     * log the client into the system
     */
    public function login()
    {
        // receive the ajax data for logging in
        $req = $this->receiveAJAX();

        // unpack the variables from the ajax request
        $kor_email = $req['kor_email'] ?? "";
        $kor_pwd   = $req['kor_pwd'  ] ?? "";
        
        // if the sent form data is invalid, return an ajax error code response
        if( !$this->validate([
             $kor_email => 'required|valid_email|min_length[1] |max_length[128]',
             $kor_pwd   => 'required            |min_length[10]|max_length[64] ']) )
        {
            $this->sendAJAX(['err' => 'form-invalid']);
            return;
        }
        
        // create models for the user and usertype
        $model_kor    = new KorisnikModel();
        $model_tipkor = new TipKorisnikModel();
        
        // initialize the remaining variables needed for verifying that the user is who they say they are
        $kor         = $model_kor->dohvatiKorisnikaPrekoEmaila($kor_email);
        $kor_tipkor  = $model_tipkor->dohvatiNazivTipaKorisnika($kor->kor_tipkor_id);
        $kor_pwdhash = password_hash($kor_pwd, PASSWORD_DEFAULT); unset($kor_pwd);

        // if the email doesnt' exist in the database, return an error code
        if( !isset($kor) )
        {
            $this->sendAJAX(['err' => 'wrong-email']);
            return;
        }

        // if the password doesnt't match, return an error code
        if( $kor_pwdhash != $kor->kor_pwd_hash )
        {
            $this->sendAJAX(['err' => 'wrong-password']);
            return;
        }
        
        // set the session variables -- user id and the user type (in string form)
        $this->session->set( compact( $kor->kor_id, $kor->kor_tipkor ) );
        // return an ajax success code response to the user
        $this->sendAJAX(['suc' => 'login-success']);
        // redirect the user to their controller type
        return redirect()->to( base_url("{$kor_tipkor}/index") );
    }

}
