/** Jovana Jankovic - 0586/17   */
/** Filip Lucic - 0188/17   */
/** Funkcionalnosti za menadzera - dodavanje novih jela u bazu - v.0.1   */

<?php namespace App\Controllers;
use App\Models\DijetaModel;
use App\Models\TipJelaModel;
use App\Models\UkusModel;
use App\Models\JeloModel;

class Menadzer extends Ulogovani
{
    
    
    public function index () {
         echo view('templejt/templejt-html.php');
    }
    
    public function unesiTipove(){   
        $this->receiveAJAX();

        $tip = new TipJelaModel();        
        $ukus =  new UkusModel();
        $dijeta = new DijetaModel();
        
        $tip->insert([
            'tipjela_naziv'=>"Pica"
        ]);
                    
        $data['success']='SUCCESS';
        $this->sendAJAX($data);
    }
    
    /** Omogucava menadzeru da doda novo jelo u bazu podataka */
    public function dodajJelo () {     
        $jelo = $this->receiveAJAX();
      
        $tip = new TipJelaModel();
        $ukus =  new UkusModel();
        $dijeta = new DijetaModel();
        $jeloModel=new JeloModel();
       
        $tip_id = $tip->dohvIdPoNazivu($jelo['jelo_tipjela']);
        $ukus_id = $ukus->dohvIdPoNazivu($jelo['jelo_ukus']);
        $dijeta_id = $dijeta->dohvIdPoNazivu($jelo['jelo_dijeta']);
        
        $jeloModel->insert([
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_masa'=>$jelo['jelo_masa'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);
        
        $data=[
         'jovana'=>"GREAT SUCCESS"   
        ];
                
        $this->sendAJAX($data); 
    }
}
