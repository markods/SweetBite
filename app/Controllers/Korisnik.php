<?php namespace App\Controllers;
// 2020-05-17 v0.1 Jovana Pavic 2017/0099
// 2020-05-18 v0.2 Jovana Jankovic 2017/0586
// 2020-05-19 v0.3 Marko Stanojevic 2017/0081

use App\Models\JeloModel;
use App\Models\TipJelaModel;
use App\Models\DijetaModel;
use App\Models\UkusModel;
use App\Models\FavoritiModel;
use App\Models\Por;
use App\Models\Stavka;
use App\Models\KorisnikModel;
use App\Models\Povod;

class Korisnik extends Ulogovani
{
    // data used for displaying the controller pages
    protected $viewdata = [
        'tipkor' => 'Korisnik',
        'tabs'   => [
            'jela'       => ['jela-korisnik', /*'filter-rezultata',*/ 'korpa'],
            'porudzbine' => ['porudzbine-korisnik'],
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
     * display the orders tab to the client
     */
    public function porudzbine()
    {
        // draw the template page with the orders tab open
        $this->drawTemplate($this->viewdata, 'porudzbine');
    }
    
    
    //-----------------------------------------------
    /** public function loadAllFood(){...}
    //dohvata iz baze sva jela i salje ih nazad
    */
    
    public function loadAllFood()
    {
        $tipJelaModel = new TipJelaModel();
        $dijetaModel = new DijetaModel();
        $ukusModel = new UkusModel();
        $favModel = new FavoritiModel();
        $stavka = new Stavka();
        
        $por = new Por();
        $por_id = null;
        if(array_key_exists('kor_id', $_SESSION)){
            $por_id = $por->korpaKorisnika($_SESSION['kor_id']);
        }
        $disc = false;
        if ($por_id != null){
            $disc = $por->imaPopust($por_id);
        }
        
        $jeloModel = new JeloModel();
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
            $jelo_id[$i] = \UUID::decodeId($jela[$i]->jelo_id);
            $jelo_naziv[$i] = $jela[$i]->jelo_naziv;
            $jelo_opis[$i] = $jela[$i]->jelo_opis;
            $jelo_slika[$i] = $jela[$i]->jelo_slika;
            $jelo_cena[$i] = $jela[$i]->jelo_cena;
            $jelo_masa[$i] = $jela[$i]->jelo_masa;
            //potreban je opis, a ne id!
            $jelo_ukus[$i] = $ukusModel->find($jela[$i]->jelo_ukus_id)->ukus_naziv;
            $jelo_dijeta[$i] = 
                $dijetaModel->dohvNazivDijete(\UUID::decodeId($jela[$i]->jelo_dijeta_id));
            $jelo_tipjela[$i] = 
                    $tipJelaModel->dohvNazivTipa(\UUID::decodeId($jela[$i]->jelo_tipjela_id));
            //proverava da li je to jelo njegov favorit
            if(array_key_exists('kor_id', $_SESSION)){
                $favor[$i] = $favModel->jeFavorit($jelo_id[$i], $_SESSION['kor_id']);
            }
            else {
                $favor[$i] = null;
            }
            //da li postoji u porudzbini
            if($por_id == null) {
                //korisnik nema porudzbinu
                $kol[$i] = null;                
            }
            else {
                $stavka_id = $stavka->stavkaJelaIzPor($jelo_id[$i], $por_id);
                if($stavka_id != null) {
                    $kol[$i] = $stavka->kolicinaJela($stavka_id);                    
                }               
                else {
                    //nema u porudzbini
                    $kol[$i] = null;
                }
            }
        }
        
        $meals = [
            'jelo_id' => $jelo_id,
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
    /** public function addFavorit(){...}
    //jelo ciji id dobije AJAX-om stavlja u favorite 
    //za korisnika cija je sesija u toku
    */
    
    public function addFavorit()
    {
        $jelo = $this->receiveAJAX();
        $jelo_id = $jelo['jelo_id'];
        
        $favModel = new FavoritiModel();
        $favModel->insert([
            'fav_kor_id'  => $_SESSION['kor_id'],
            'fav_jelo_id' => $jelo_id
        ]);
    }

    //-----------------------------------------------
    /** public function removeFavorit(){...}
    //jelo ciji id dobije AJAX-om uklanja iz favorita
    //korisnika cija je sesija u toku
    */
    
    public function removeFavorit()
    {
        $jelo = $this->receiveAJAX();
        $jelo_id = $jelo['jelo_id'];
        
        $favModel = new FavoritiModel();
        $id = $favModel->idFavorita($jelo_id, $_SESSION['kor_id']);
        $favModel->delete($id);
        
        
    }
    
    //-----------------------------------------------
    /** public function changeAmount(){...}
    // Manje kolicinu u jela dobijenog AJAX-om
    // Ako prijavljeni korisnik nema svoju korpu pravi je
    // Ako u korpi nema tu stavku pravi se stavka
    // A ako ima stavku onda joj se promeni kolicina
    // AJAX-om vraca trenutnu kolicinu tog jela u korpi
    */
    
    public function changeAmount()
    {
        $json = $this->receiveAJAX();
        $jelo_id = $json['jelo_id'];
        $kol = $json['kol'];
        
        $kor_id = $_SESSION['kor_id'];
        
        $por = new Por();
        $por_id = $por->korpaKorisnika($kor_id);
        
        //ako korisnik nema korpu napravimo novu
        if ($por_id == null) {
            $porudz = $por->porudzbineKorisnika($kor_id);
            if (count($porudz) % 3 == 0){
                $por_id = $por->insert(['por_kor_id'      => $kor_id,
                                        'por_popust_proc' => 10
                                        ]);
            }
            else {
                $por_id = $por->insert(['por_kor_id'      => $kor_id,
                                        'por_popust_proc' => 0
                                       ]);
            }
        }
             
        //provera da li postoji ta stavka u korpi
        $stavkaModel = new Stavka();
        $stavka_id = $stavkaModel->stavkaJelaIzPor($jelo_id, $por_id);
        
        $amo = 0;
        //ako stavka ne postoji
        if($stavka_id == null){
            //napravi stavku sa datom kolicinom
            
            //potrebna cena po komadu
            $jeloModel = new JeloModel();
            $jelo = $jeloModel->dohvPoId($jelo_id);
            $cenakom = $jelo->jelo_cena;
            
            if($kol == 'p1'){
                $stavkaModel->insert([
                    'stavka_por_id' => $por_id,
                    'stavka_jelo_id' => $jelo_id,
                    'stavka_kol'     => 1,
                    'stavka_cenakom' => $cenakom
                ]);
                $amo = 1;
            }
            else if($kol > 0){
                $stavkaModel->insert([
                    'stavka_por_id' => $por_id,
                    'stavka_jelo_id' => $jelo_id,
                    'stavka_kol'     => $kol,
                    'stavka_cenakom' => $cenakom
                ]);
                $amo = $kol;
            }
            //ako je '-1' ne pravi se porudzbina
        }    
        //ako stavka postoji
        else {
            $amo = $stavkaModel->kolicinaJela($stavka_id);
            if($kol == 'p1'){
                $amo += 1;
            }
            else if ($kol === '-1'){
                $amo -= 1;
            }
            else{
                $amo = $kol;
            }
            $stavkaModel->update($stavka_id, ['stavka_kol' => $amo]);
        }       
        $this->sendAJAX($amo);    
    }
    
    //-----------------------------------------------
    /** public function getFood(){...}
    //Dohvata opis jela ciji id je stigao AJAX-om
    */
    
    public function getFood()
    {
        $jelo = $this->receiveAJAX();
        $jelo_id = $jelo['jelo_id'];
        
        $jeloModel = new JeloModel();
        $find = $jeloModel->dohvPoId($jelo_id);
        
        $food = [
            'jelo_id' => $jelo_id,
            'jelo_naziv' => $find->jelo_naziv,
            'jelo_cena'  => $find->jelo_cena,
            'jelo_masa'  => $find->jelo_masa
        ];
        
        $this->sendAJAX($food);
    }
    
    //-----------------------------------------------
    /** public function removeFromOrder(){...}
    // uklanja iz baze stavku ulogovanog korisnika
    // za jelo ciji id je stigao AJAX zahtevom
    */
    
    public function removeFromOrder()
    {
        $jelo = $this->receiveAJAX();
        $jelo_id = $jelo['jelo_id'];
        
        $kor_id = $_SESSION['kor_id'];
        $por = new Por();
        $por_id = $por->korpaKorisnika($kor_id);
        
        $stavka = new Stavka();
        $stavka_id = $stavka->stavkaJelaIzPor($jelo_id, $por_id);
        
        $stavka->delete($stavka_id);
    }
    
    //-----------------------------------------------
    /** public function poruci(){...}
    // validira zahtev za porucivanjem
    // Ako je neuspesno vraca greske
    // Ako je uspesno cuva u bazi
    */
    
    public function poruci()
    {
        
    }
    
    //-----------------------------------------------

    /** Autor: Jovana Jankovic 0586/17 - funkcija za dohvatanje svih porudzbina i neophodnih podataka za porudzbinu musterije */ 
    /** Filip Lucic 0188/17 - dopuna statusa za porudzbine u skladu sa bazom*/
    public function dohvatiPorudzbineKorisnik(){ 
         $korisnikModel=new KorisnikModel();
         $kor_id=$korisnikModel->dohvatiIdNaOsnovuImena("korisnik");       
         $porudzbina=new Por();
         $por=$porudzbina->porudzbineKorisnika($kor_id);
        
         $stavkaModel=new Stavka();
         $jeloModel=new JeloModel();
         
          for ($i = 0; $i < count($por); $i++) {
           $stavke=$stavkaModel->dohvatiStavke($por[$i]->por_id);
            
                for($j=0; $j<count($stavke); $j++){
                    $naziv_jela[$j]=$jeloModel->dohvatiNazivJela($stavke[$j]->stavka_jelo_id);      
                    $masa_jela[$j]=$jeloModel->dohvatiMasu($stavke[$j]->stavka_jelo_id);
                    $kol_jela[$j]=$stavke[$j]->stavka_kol;
                    $cena_jela[$j]=$stavke[$j]->stavka_cenakom;
                }
                 
            //dodavanje atributa objektu
            $por[$i]->naziv_jela=$naziv_jela;
            $por[$i]->masa_jela=$masa_jela;
            $por[$i]->kol_jela=$kol_jela;
            $por[$i]->cena_jela=$cena_jela;
            
            if($por[$i]->por_datodluke==null)
                $por[$i]->status = 0;
            if($por[$i]->por_odluka==='prihvacena')
                $por[$i]->status = 1;
            if($por[$i]->por_odluka==='odbijena')
                $por[$i]->status = 2;    
            if($por[$i]->por_datizrade!=null)
                $por[$i]->status = 3;
            if($por[$i]->por_datpreuz!=null)
                $por[$i]->status = 4;
          }  
      
         $this->sendAJAX($por); 
    }
    
}



