<?php namespace App\Controllers;
use App\Models\DijetaModel;
use App\Models\TipJelaModel;
use App\Models\UkusModel;
use App\Models\JeloModel;

/** Jovana Jankovic - 0586/17   */
/** Filip Lucic - 0188/17   */
/** Funkcionalnosti za menadzera - dodavanje novih jela u bazu - v.0.1   */

class Menadzer extends Ulogovani
{    
    public function index () {
         echo view('templejt/templejt-html.php');
    }
    
    /**Autor:Jovana Jankovic 0586/17 - pomocna fja za testiranje tabele Jela*/
    public function unesiTipove(){   
        $this->receiveAJAX();

        $tip = new TipJelaModel();        
        $ukus =  new UkusModel();
        $dijeta = new DijetaModel();
        
        $tip->insert([
            'tipjela_naziv'=>"Pita"
        ]);
        $tip->insert([
            'tipjela_naziv'=>"Rostilj"
        ]);
        $tip->insert([
            'tipjela_naziv'=>"Pica"
        ]);
        $tip->insert([
            'tipjela_naziv'=>"Pasta"
        ]);$tip->insert([
            'tipjela_naziv'=>"Riba"
        ]);
        
        $ukus->insert([
            'ukus_naziv'=>"Slatko"
        ]);
        
        
        $ukus->insert([
            'ukus_naziv'=>"Slano"
        ]);
        $ukus->insert([
            'ukus_naziv'=>"Ljuto"
        ]);
        
        
        $dijeta->insert([
            'dijeta_naziv'=>"Posno"
        ]);
        
        
        $dijeta->insert([
            'dijeta_naziv'=>"Vegetarijansko"
        ]);
        
        
        $dijeta->insert([
            'dijeta_naziv'=>"Bez glutena"
        ]);
        
                    
        $data['success']='SUCCESS';
        $this->sendAJAX($data);
    }
    
    /** Autor: Filip Lucic 17/0188 - omogucava menadzeru da doda novo jelo u bazu podataka */
    public function dodajJelo () {     
        $jelo = $this->receiveAJAX();
      
        $tip = new TipJelaModel();
        $ukus =  new UkusModel();
        $dijeta = new DijetaModel();
        $jeloModel=new JeloModel();
       
        $tip_id = $tip->dohvIdPoNazivu($jelo['jelo_tipjela']);
        $ukus_id = $ukus->dohvIdPoNazivu($jelo['jelo_ukus']);
        $dijeta_id = $dijeta->dohvIdPoNazivu($jelo['jelo_dijeta']);
        
        $jelo['jelo_id']=$jeloModel->insert([
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_masa'=>$jelo['jelo_masa'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);
              
        $this->sendAJAX($jelo); 
    }
    
    /** Autor: Jovana Jankovic 0586/17 - Fja koja radi update Jela koja menadzer promeni*/
    public function updateJelo(){
        
        $jelo = $this->receiveAJAX();
        $tip = new TipJelaModel();
        $ukus =  new UkusModel();
        $dijeta = new DijetaModel();
        $jeloModel = new JeloModel();
         
        $tip_id = $tip->dohvIdPoNazivu($jelo['jelo_tipjela']);
        $ukus_id = $ukus->dohvIdPoNazivu($jelo['jelo_ukus']);
        $dijeta_id = $dijeta->dohvIdPoNazivu($jelo['jelo_dijeta']);
                
        if(!isset($jelo['jelo_cena']))
         {   
                if(!isset($jelo['jelo_masa'])){    
                $jeloModel->update($jelo['jelo_id'],[
                'jelo_naziv'=>$jelo['jelo_naziv'],
                'jelo_opis'=>$jelo['jelo_opis'],
                'jelo_tipjela_id'=>$tip_id,
                'jelo_ukus_id'=>$ukus_id,
                'jelo_dijeta_id'=>$dijeta_id
                    ]);
                $this->sendAJAX($jelo); 
                return;
          }
             else
             {
                $jeloModel->update($jelo['jelo_id'],[
                'jelo_naziv'=>$jelo['jelo_naziv'],
                'jelo_opis'=>$jelo['jelo_opis'],
                'jelo_masa'=>$jelo['jelo_masa'],
                'jelo_tipjela_id'=>$tip_id,
                'jelo_ukus_id'=>$ukus_id,
                'jelo_dijeta_id'=>$dijeta_id 
            ]);

                $this->sendAJAX($jelo); 
                return;
             }
            
        }
        elseif(!isset($jelo['jelo_masa'])){
            $jeloModel->update($jelo['jelo_id'],[
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);
            $this->sendAJAX($jelo); 
            return;
        }
        else{
        
        $jeloModel->update($jelo['jelo_id'],[
            'jelo_naziv'=>$jelo['jelo_naziv'],
            'jelo_opis'=>$jelo['jelo_opis'],
            'jelo_cena'=>$jelo['jelo_cena'],
            'jelo_masa'=>$jelo['jelo_masa'],
            'jelo_tipjela_id'=>$tip_id,
            'jelo_ukus_id'=>$ukus_id,
            'jelo_dijeta_id'=>$dijeta_id 
        ]);
 
            $this->sendAJAX($jelo); 
        }    
    }
     /** Autor: Filip Lucic 17/0188 - omogucava menadzeru da dohvati sva jela, i ispise ih putem Ajaxa pri ucitavanju stranice */
    public function dohvatiSvaJela() {
        $jeloModel = new JeloModel();
        $jela = $jeloModel->dohvSve();
        $this->sendAJAX($jela);       
    }
    
    /** Autor: Jovana Jankovic 17/0586 - omogucava brisanje jela iz ponude ketering servisa*/
    public function obrisiJelo(){
        $jelo = $this->receiveAJAX();
        $jeloModel = new JeloModel();
        $jeloModel->delete($jelo['jelo_id']);
        $data=[
            'success'=>"Uspesno ste izbrisali jelo iz ponude!",
            'jelo_id'=> $jelo['jelo_id']
        ];
        $this->sendAJAX($data);       
    }
    
    /** Autor: Jovana Jankovic 0586/17 - fja za sakrivanje jela iz ponude */
    public function sakrijJelo(){
        $jelo = $this->receiveAJAX();
        $jeloModel = new JeloModel();
        $jeloModel->update($jelo['jelo_id'],
                ['jelo_datsakriv'=> date('Y-m-d H:i:s')]);
        $data=[
            'success'=>"Uspesno ste izbrisali jelo iz ponude!",
            'jelo_id'=> $jelo['jelo_id']
        ];
        $this->sendAJAX($data);   
    }
}

