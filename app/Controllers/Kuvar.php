<?php namespace App\Controllers;
// 2020-05-18 v0.1 Jovana Pavic 2017/0099
// 2020-05-19 v0.2 Marko Stanojevic 2017/0081
// 2020-05-21 v0.3 Jovana Pavic 2017/0099

use App\Models\Stavka;
use App\Models\Povod;
use App\Models\Jelo;
use App\Models\Por;

/**
 * Kuvar - klasa kontrolera, sva interakcija
 *         korisnika sa privilegijom kuvara sa bazom 
 *         se realizuje pomocu ove klase  
 * 
 * @version 0.3
 */
class Kuvar extends Ulogovani
{
    protected $viewdata = [
        'tipkor' => 'Kuvar',
        'tabs'   => [
            'porudzbine' => ['porudzbine-kuvar'],
        ],
    ];
    
    /**
     * display the orders tab to the client
     */
    public function porudzbine()
    {
        // draw the template page with the orders tab open
        $this->drawTemplate($this->viewdata, 'porudzbine');
    }
    
    
    //-----------------------------------------------
    /** public function loadNotFinishedOrders(){...}
     * Ucitava sve porudzbine koje nisu napravljene
     */
    public function loadNotFinishedOrders(){
        $stavka = new Stavka();
        $povod  = new Povod();
        $jelo   = new Jelo();
        $por    = new Por();
        
        $svePor = $por->zaPravljenje();
        
        $por_id        = [];
        $por_povod     = [];    //opis povoda
        $por_za_dat    = [];
        $stavke_id     = [];
        $stavke_naziv  = [];
        $stavke_kol    = [];
        $stavke_masa   = [];
        $stavke_status = [];
        
        for($i=0; $i<count($svePor); $i++) {
            $por_id[$i]     = $svePor[$i]->por_id;
            $por_povod[$i]  = $povod->povodOpis($svePor[$i]->por_povod_id);
            $por_za_dat[$i] = $svePor[$i]->por_za_dat;
            
            $sveStavke = $stavka->sveIzPor($svePor[$i]->por_id);
            $id     = [];
            $naziv  = [];
            $kol    = [];
            $masa   = [];
            $status = [];
            for($j=0; $j<count($sveStavke); $j++){
                $id[$j]  = "".$sveStavke[$j]->stavka_id."";
                $kol[$j] = $sveStavke[$j]->stavka_kol;
                
                if ($sveStavke[$j]->stavka_datizrade == null) $status[$j] = false;
                else $status[$j] = true;
                
                $s_jelo = $jelo->dohvPoId($sveStavke[$j]->stavka_jelo_id);
                $naziv[$j] = $s_jelo->jelo_naziv;
                $masa[$j]  = $s_jelo->jelo_masa;
            }
            $stavke_id[$i]     = $id;
            $stavke_naziv[$i]  = $naziv;
            $stavke_kol[$i]    = $kol;
            $stavke_masa[$i]   = $masa;
            $stavke_status[$i] = $status;
        }
        $orders = [
            'por_id'        => $por_id,
            'por_povod'     => $por_povod,
            'por_za_dat'    => $por_za_dat,
            'stavke_id'     => $stavke_id,
            'stavke_naziv'  => $stavke_naziv,
            'stavke_kol'    => $stavke_kol,
            'stavke_masa'   => $stavke_masa,
            'stavke_status' => $stavke_status
        ];
        $this->sendAJAX($orders);
    }
    
    //-----------------------------------------------
    /** public function dishDone(){...}
     * Postavlja datum izrade primljene stavke
     */
    public function dishDone()
    {
        $stavka = new Stavka();
        $stavka_id = ($this->receiveAJAX())['stavka_id'];
        $stavka->napravljenaStavka($stavka_id);
    }
    
    //-----------------------------------------------
    /** public function dishNotDone(){...}
     * Uklanja datum izrade primljene stavke
     */
    public function dishNotDone()
    {
        $stavka = new Stavka();
        $stavka_id = ($this->receiveAJAX())['stavka_id'];
        $stavka->nijeNapravljenaStavka($stavka_id);
    }
    
    //-----------------------------------------------
    /** public function orderDone(){...}
     * Postavlja datum izrade primljene porudzbine
     */
    public function orderDone()
    {
        $por = new Por();
        $por_id = ($this->receiveAJAX())['por_id'];
        $por->napravljena($por_id);        
    }
    
}
