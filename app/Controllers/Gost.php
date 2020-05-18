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
        echo view('templejt/templejt-html.php');
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
        
        // create models for the user and usertype
        $model_kor    = new KorisnikModel();
        $model_tipkor = new TipKorisnikModel();
        
        // get the user with the given email
        $kor = $model_kor->dohvatiKorisnikaPrekoEmaila($kor_email);
        // if the user doesnt' exist in the database, return an error code
        if( !isset($kor) )
        {
            $this->sendAJAX(['#login-email-help' => 'pogresan email']);
            return;
        }

        // if the given password doesnt't match the one in the database, return an error code
        if( !password_verify($kor_pwd, $kor->kor_pwdhash) )
        {
            $this->sendAJAX(['#login-password-help' => 'pogresna lozinka']);
            return;
        }
        
        // initialize local variables (to be embedded in session)
        $kor_id      = $kor->kor_id;
        $kor_tipkor  = $model_tipkor->dohvatiNazivTipaKorisnika($kor->kor_tipkor_id);
        
        // set the session variables -- user id and the user type (in string form)
        $this->session->set( compact( 'kor_id', 'kor_tipkor' ) );
        // redirect the user to their controller type
        $this->sendAJAX(['redirect' => base_url("{$kor_tipkor}/index")]);
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
        if( !$this->validate(
        [   // rules
            'kor_naziv' => 'required'                       .'|max_length[64]' ,
            'kor_email' => 'required|valid_email'           .'|max_length[128]',
            'kor_tel'   => 'required|numeric' .'|min_length[8]|max_length[16]' ,
            'kor_pwd'   => 'required'         .'|min_length[8]|max_length[64]'
        ],
        [   // messages
            'kor_naziv' => ['required' => 'polje je obavezno',                                                                                                                'max_length[64]'  => 'puno ime predugacko'      ],
            'kor_email' => ['required' => 'polje je obavezno', 'valid_email' => 'neispravan format email-a',                                                                  'max_length[128]' => 'email predugacak'         ],
            'kor_tel'   => ['required' => 'polje je obavezno', 'numeric'     => 'broj telefona treba da bude bez razmaka', 'min_length[8]' => 'broj telefona previse kratak', 'max_length[16]'  => 'broj telefona predugacak' ],
            'kor_pwd'   => ['required' => 'polje je obavezno',                                                             'min_length[8]' => 'lozinka previse kratka',       'max_length[64]'  => 'lozinka predugacka'       ]
        ]) )
        {
            // get all validation errors
            $err_old = $this->validator->getErrors();
            
            // map from server side errors to the client side errors
            $err_map = [
                'kor_naziv' => '#register-full-name-help',
                'kor_email' => '#register-email-help'    ,
                'kor_tel'   => '#register-phone-num-help',
                'kor_pwd'   => '#register-password-help'
            ];
            
            // map the server side errors to the client side errors
            $err_new = [];
            foreach( $err_old as $key_old => $value )
            {
                //      [---$err_new key---]
                $err_new[$err_map[$key_old]] = $value;
            }
            
            // send the accumulated form errors to the client
            $this->sendAJAX($err_new);
            return;
        }
        
        // create models for the user and usertype
        $model_kor    = new KorisnikModel();
        $model_tipkor = new TipKorisnikModel();

        // initialize the remaining variables needed for the database record in table 'user'
        $kor_pwdhash   = password_hash($kor_pwd, PASSWORD_DEFAULT);
        $kor_tipkor    = 'Korisnik';
        $kor_tipkor_id = $model_tipkor->dohvatiIDTipaKorisnika($kor_tipkor);
        
        // if the email already exists in the database, return an error code
        if( $model_kor->daLiPostojiEmail($kor_email) )
        {
            $this->sendAJAX(['#register-email-help' => 'email zauzet']);
            return;
        }
        
        // try to insert a new user account record into the 'user' table
        $kor_id = $model_kor->insert( compact(
            'kor_naziv',
            'kor_email',
            'kor_tel',
            'kor_pwdhash',
            'kor_tipkor_id'
        ));
        
        // if the insertion failed, return an error code
        if( !isset($kor_id) )
        {
            $this->sendAJAX(['#register-help' => 'neuspesna registracija']);
            return;
        }
        
        // set the session variables -- user id and the user type (in string form)
        $this->session->set( compact( 'kor_id', 'kor_tipkor' ) );
        // return an ajax success code response to the user
        $this->sendAJAX(['success' => 'uspesna registracija']);
        // redirect the user to their controller type
        $this->sendAJAX(['redirect' => base_url("{$kor_tipkor}/index")]);
    }

}
