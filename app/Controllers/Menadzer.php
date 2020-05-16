<?php namespace App\Controllers;

use App\Models\DijetaModel;
use App\Models\TipJelaModel;
use App\Models\UkusModel;
use App\Models\JeloModel;



/**
 * 
 */
class Menadzer extends Ulogovani
{
    
    
    public function index () {
         echo view('templejt/templejt-html.php');
    }
    
    public function dodajJelo () {
        //dohvaceno jelo je u formatu niz kao kljuc/vrednost
        $jelo = $this->receiveAJAX();
        $tip = new TipJelaModel();
        $ukus =  new UkusModel();
        $dijeta = new Dijeta();
        $jeloModel=new JeloModel();
        $tip->insert([
            'tipjela_naziv' =>'tip',
        ]);
         $ukus->insert([
            'ukus_naziv' =>'ukus',
        ]);
          $dijeta->insert([
            'dijeta_naziv' =>'dijeta',
        ]);
        $tip_id = $tip->dohvIdPoNazivu('tip');
        $ukus_id = $ukus->dohvIdPoNazivu('ukus');
        $dijeta_id = $dijeta->dohvIdPoNazivu('dijeta');
        
        $jeloModel->insert([
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_masa'=>$jelo['jelo_masa'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id,
            
        ]);
        $data = [];
        $data['jovana']='jovana';
        $data['filip']='filip';
                
        
        $this->sendAJAX($data);
 
    }
}
