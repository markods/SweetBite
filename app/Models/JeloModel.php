<?php namespace App\Models;

use CodeIgniter\Model;

//Autor:Filip Lučić 2017/0188

class JeloModel extends Model
{       
        //PROVERITI TIPOVE POVRATNIH I PROSLEDJENJIH VREDNOSTI, DA LI SE PRI UPISU PROSLEDJUJE DATE/INT, ili string. PRI POVRATKU ISTO.
        protected $table      = 'jelo';
        protected $primaryKey = 'jelo_id';
        protected $returnType = 'object';
        protected $allowedFields = ['jelo_naziv', 'jelo_opis', 'jelo_slika', 'jelo_cena', 'jelo_masa', 'jelo_tipjela_id', 'jelo_ukus_id', 'jelo_dijeta_id', 'jelo_datkre', 'jelo_datsakriv', 'jelo_datuklanj'];
        
        
        
        protected $useTimestamps = true;
        protected $createdField  = 'jelo_datkre';
        protected $dateFormat = 'datetime';
        
        //videti trim za format slike i int/float/binary
        protected $validationRules    = [
                        'jelo_naziv' => 'trim|required',
                        'jelo_opis' => 'trim|required',
                        'jelo_slika'   => 'trim|required',
                        'jelo_cena' => 'required',
                        'jelo_masa' => 'required',
                        'jelo_tipjela_id' => 'trim|required',
                        'jelo_ukus_id' => 'trim|required',
                        'jelo_dijeta_id' => 'trim|required'                        
                ];
       protected $validationMessages = [
                   'jelo_naziv' => ['required' => 'Naziv jela je obavezan!'],
                   'jelo_opis' => ['required' => 'Opis jela je obavezan!'],
                   'jelo_slika' => ['required' => 'Slika jela je obavezna!'],
                   'jelo_cena'   => ['required' => 'Cena jela je obavezna!'],
                   'jelo_masa'   => ['required' => 'Masa jela je obavezna!'],
                   'jelo_tipjela_id'   => ['required' => 'Identifikator tipa jela je obavezan!'],
                   'jelo_ukus_id'   => ['required' => 'Identifikator ukusa jela je obavezan!'],
                   'jelo_dijeta_id'   => ['required' => 'Identifikator dijete je obavezan!']                   
               ];
        protected $skipValidation = false;
        
        public function dohvSve() {
            return $this->findAll();
        }

        public function dohvPoId($id) {
            return $this->find($id);
        }

        public function dohvPoImenu($naziv_jela) {
            return $this->where('jelo_naziv', $naziv_jela)->findAll();
        }

        public function insert($data=NULL, $returnID=true) {
        $id = \UUIDLib::generateID();        
        $data['jelo_id'] = $id;
        if(parent::insert($data, $returnID) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return $id;
        }
        
        public function update($id=NULL, $data=NULL):bool {
        if(parent::update($id, $data) === false){
            echo '<h3>Greske u formi upisa:</h3>';
            $errors = $this->errors();
            foreach ($errors as $error) {
                echo "<p>->$error</p>";   
            }
            return false;
        }
        return true;
        }
        
        
        //SOLVE how to do it, and what parameters to 
        
        //tip, dijeta i ukus su nizovi cije id-jeve dohvatam, oni nastaju u kontroleru tako sto se
        //sadrzaj post niza pise u njih, za svaki value istog kljuca (jer je check box) se dodaje tamo element u niz
//        public function pretragaPoParametrima($tip, $dijeta, $ukus, $tekst) {
//            //vrste_jela, ukus, dijetalni_zahtevi -> nazivi formi
//            //post value kod checkboxa je ili value ili null
//            $type = array();
//            $diet = array();
//            $taste = array();
//            $return = array();
//            //for petlja, moze da se napise drugacije
//            foreach ($tip as $tipovi) {
//                $type[key] = $tipovi;
//            }
//            foreach ($tip as $tipovi) {
//                $type.array_push($tipovi);
//            }
//            foreach ($tip as $tipovi) {
//                $type.array_push($tipovi);
//            }
//        
//            //$multipleWhere = ['name' => $name, 'email' => $email, 'status' => $status]; na netu ovako rade, ali where onda primi ovaj niz
////            if($tekst!=null) { //moze i isset($ukus_id)
////                if($tip_id==null && $ukus_id==null && $dijeta_id==null) 
////                    return $this->like('jelo_naziv', $tekst);
////                if($tip_id!=null && $ukus_id==null && $dijeta_id==null) 
////                    return $this->like('jelo_naziv', $tekst)->where('jelo_tipjela_id', $tip_id);
////                if($tip_id!=null && $ukus_id!=null && $dijeta_id==null) {
////                    $multipleWhere == ['jelo_tipjela_id' => $tip_id, 'jelo_ukus_id', $ukus_id ];
////                    return $this->like('jelo_naziv', $tekst)->where('jelo_tipjela_id',$tip_id)->andWhere('jelo_ukus_id',$ukus_id);
////                }
////                if($tip_id!=null && $ukus_id!=null && $dijeta_id!=null) {
////                    //$multipleWhere == ['jelo_tipjela_id' => $tip_id, 'jelo_ukus_id'=> $ukus_id , 'jelo_dijeta_id'=>$dijeta_id];
////                    
////                    return $this->like('jelo_naziv', $tekst)->where('jelo_tipjela_id', $tip_id)->andWhere('jelo')
////                }
////                if($tip_id==null && $ukus_id!=null && $dijeta_id!=null) {
////                    //$multipleWhere == ['jelo_ukus_id'=> $ukus_id , 'jelo_dijeta_id'=>$dijeta_id];
////                    return $this->like('jelo_naziv', $tekst)->where($multipleWhere);
////                    where('key',value)->orWhere('ke')
////                }
////                
//
//
//            }
//                
        

}

