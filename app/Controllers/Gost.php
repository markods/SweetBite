<?php namespace App\Controllers;
use \App\Models\Kor;
use \App\Models\Tipkor;
// 2020-05-10 v0.0 Jovana Jankovic 2017/0586, Filip Lucic 2017/0188
// 2020-05-14 v0.1 Marko Stanojevic 2017/0081
// 2020-05-19 v0.2 Marko Stanojevic 2017/0081
// 2020-05-21 v0.3 Jovana Pavic 2017//0099

use App\Models\Jelo;
use App\Models\Tipjela;
use App\Models\Dijeta;
use App\Models\Ukus;
use App\Models\Fav;
use App\Models\Por;
use App\Models\Stavka;
use App\Models\Povod;

/**
 * this is the default controller for the web application
 * it handles requests from users that aren't logged in
 */
class Gost extends BaseController
{
    // data used for displaying the controller pages
    protected $viewdata = [
        'tipkor' => 'Gost',
        'tabs'   => [
            'jela' => ['jela-korisnik', /*'filter-rezultata',*/ 'korpa'],
        ],
    ];
    
    /**
     * display the food tab to the client
     */
    public function jela()
    {
        // draw the template page with the food tab open
        $this->drawTemplate($this->viewdata, 'jela');
    }
    
    
    /**
     * log the client into the system
     * 
     * @return none
     */
    public function login()
    {
        // receive the ajax data for logging in
        $req = $this->receiveAJAX();

        // unpack the variables from the ajax request
        $kor_email = $req['kor_email'] ?? "";
        $kor_pwd   = $req['kor_pwd'  ] ?? "";
        
        // create models for the user and usertype
        $model_kor    = new Kor();
        $model_tipkor = new Tipkor();
        
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
        // redirect the user to their default controller and method
        $this->sendAJAX(['redirect' => base_url(nightbird_def_path[$kor_tipkor])]);
    }

    
    /**
     * create an account for the client
     * 
     * @return none
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
        $model_kor    = new Kor();
        $model_tipkor = new Tipkor();

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
        // redirect the user to their default controller and method
        $this->sendAJAX(['redirect' => base_url(nightbird_def_path[$kor_tipkor])]);
    }

    
    //-----------------------------------------------
    /** public function loadAllFood(){...}
    // Dohvata iz baze sva jela i salje ih nazad
    */
    
    public function loadAllFood()
    {
        $tipJelaModel = new Tipjela();
        $dijetaModel = new Dijeta();
        $favModel = new Fav();
        $ukusModel = new Ukus();
        $stavka = new Stavka();
        
        $por = new Por();
        $por_id = null;
        $disc = false;
        
        $jeloModel = new Jelo();
        $jela = $jeloModel->dohvSve();
        
        $jelo_id = [];
        $jelo_naziv = [];
        $jelo_opis = [];
        $jelo_slika = [];
        $jelo_cena = [];
        $jelo_masa = [];
        $jelo_tipjela = [];
        $jelo_ukus = [];
        $jelo_dijeta = [];
        $favor = [];
        $kol = [];
        
        for($i = 0; $i < count($jela); $i++) {
            $jelo_id[$i]    = $jela[$i]->jelo_id;
            $jelo_naziv[$i] = $jela[$i]->jelo_naziv;
            $jelo_opis[$i]  = $jela[$i]->jelo_opis;
            $jelo_slika[$i] = $jela[$i]->jelo_slika;
            $jelo_cena[$i]  = $jela[$i]->jelo_cena;
            $jelo_masa[$i]  = $jela[$i]->jelo_masa;
            
            //potreban je opis, a ne id!
            $jelo_ukus[$i]    = $ukusModel->dohvUkus($jela[$i]->jelo_ukus_id)->ukus_naziv;
            $jelo_dijeta[$i]  = $dijetaModel->dohvNazivDijete($jela[$i]->jelo_dijeta_id);
            $jelo_tipjela[$i] = $tipJelaModel->dohvNazivTipa($jela[$i]->jelo_tipjela_id);
            
            //nema favorite jer nije ulogovan
            $favor[$i] = null;
            
            //on nema svoju porudzbinu pa je kolicina null
            $kol[$i] = null;
        }
        
        $meals = [
            'jelo_id'      => $jelo_id,
            'jelo_naziv'   => $jelo_naziv,
            'jelo_opis'    => $jelo_opis,
            'jelo_slika'   => $jelo_slika,
            'jelo_cena'    => $jelo_cena,
            'jelo_masa'    => $jelo_masa,
            'jelo_tipjela' => $jelo_tipjela,
            'jelo_ukus'    => $jelo_ukus,
            'jelo_dijeta'  => $jelo_dijeta,
            'favor'        => $favor,
            'kol'          => $kol,
            'disc'         => $disc
        ];
        $this->sendAJAX($meals);
    }
     
    //-----------------------------------------------
    /** public function getFood(){...}
    // Dohvata opis jela ciji id je stigao AJAX-om
    */
    
    public function getFood()
    {
        $jelo = $this->receiveAJAX();
        $jelo_id = $jelo['jelo_id'];
        
        $jeloModel = new Jelo();
        $find = $jeloModel->dohvPoId($jelo_id);
        
        $food = [
            'jelo_id'    => $jelo_id,
            'jelo_naziv' => $find->jelo_naziv,
            'jelo_cena'  => $find->jelo_cena,
            'jelo_masa'  => $find->jelo_masa
        ];
        
        $this->sendAJAX($food);
    }
    
    //-----------------------------------------------
    /** public function sviPovodi(){...}
    // Salje AJAX-om sve povode iz baze
    */
    
    public function sviPovodi()
    {
        $povod = new Povod();
        $povodi = $povod->sviPovodi();   
        $id = [];
        $opis = [];
        for($i=0; $i<count($povodi); $i++){
            $id[$i]   = $povodi[$i]->povod_id;
            $opis[$i] = $povodi[$i]->povod_opis;
        }    
        $povodii = [
            'id'   => $id,
            'opis' => $opis
        ];
        $this->sendAJAX($povodii);
    }

    //-----------------------------------------------
    /** public function dohvatiSliku(){...}
    // Dohvata sliku za jelo ciji id dobije AJAX-om
    */
   
    public function dohvatiSliku() 
    {
        $jelo = new Jelo();
        $rec = $this->receiveAJAX();
        
        $slika = $jelo->dohvatiSliku($rec['jelo_id']);
        
        $data = [
            "jelo_slika" => $slika
        ];
        $this->sendAJAX($data);
    }
    
    //-----------------------------------------------
    
}