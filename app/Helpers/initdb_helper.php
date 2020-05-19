<?php
// 2020-05-17 v0.1 Marko Stanojevic 2017/0081


if( !function_exists('initdb'))
{
    /**
     * initialize the database with generic data
     * 
     * @return none
     */
    function initdb()
    {
        // create user types
        $tipkor = new \App\Models\TipKorisnikModel();
        $tipkor->insert(['tipkor_naziv' => 'Admin'   ]);
        $tipkor->insert(['tipkor_naziv' => 'Menadzer']);
        $tipkor->insert(['tipkor_naziv' => 'Kuvar'   ]);
        $tipkor->insert(['tipkor_naziv' => 'Korisnik']);

        // create generic users of all types
        $kor = new \App\Models\KorisnikModel();
        $kor_naziv  = ['admin',               'menadzer',               'kuvar',               'korisnik'              ];
        $kor_email  = ['admin@nightbird.com', 'menadzer@nightbird.com', 'kuvar@nightbird.com', 'korisnik@nightbird.com'];
        $kor_tel    = ['+381000000000',       '+381111111111',          '+381222222222',       '+381333333333'         ];
        $kor_pwd    = ['admin',               'menadzer',               'kuvar',               'korisnik'              ];
        $kor_tipkor = ['Admin',               'Menadzer',               'Kuvar',               'Korisnik'              ];

        for( $i = 0; $i < 4; $i++ )
        {
            $kor_pwdhash = password_hash($kor_pwd[$i], PASSWORD_DEFAULT);
            $kor->insert([
                'kor_naziv'     => $kor_naziv[$i],
                'kor_email'     => $kor_email[$i],
                'kor_tel'       => $kor_tel[$i],
                'kor_pwdhash'   => $kor_pwdhash,
                'kor_tipkor_id' => $tipkor->dohvatiIDTipaKorisnika($kor_tipkor[$i]),
            ]);
        }

        // create dish types
        $tipjela = new \App\Models\TipJelaModel();
        $tipjela->insert(['tipjela_naziv' => 'Predjelo']);
        $tipjela->insert(['tipjela_naziv' => 'Kuvano jelo']);
        $tipjela->insert(['tipjela_naziv' => 'Roštilj' ]);
        $tipjela->insert(['tipjela_naziv' => 'Salata'  ]);
        $tipjela->insert(['tipjela_naziv' => 'Supa'    ]);
        $tipjela->insert(['tipjela_naziv' => 'Čorba'   ]);
        $tipjela->insert(['tipjela_naziv' => 'Riba'    ]);
        $tipjela->insert(['tipjela_naziv' => 'Morski plodovi']);
        $tipjela->insert(['tipjela_naziv' => 'Pasta'   ]);
        $tipjela->insert(['tipjela_naziv' => 'Pica'    ]);
        $tipjela->insert(['tipjela_naziv' => 'Pita'    ]);
        $tipjela->insert(['tipjela_naziv' => 'Kolač'   ]);
        $tipjela->insert(['tipjela_naziv' => 'Pecivo'  ]);
        $tipjela->insert(['tipjela_naziv' => 'Torta'   ]);

        // create taste types
        $ukus = new \App\Models\UkusModel();
        $ukus->insert(['ukus_naziv' => 'slatko']);
        $ukus->insert(['ukus_naziv' => 'slano' ]);
        $ukus->insert(['ukus_naziv' => 'ljuto' ]);

        // create diet types
        $dijeta = new \App\Models\DijetaModel();
        $dijeta->insert(['dijeta_naziv' => 'posno'         ]);
        $dijeta->insert(['dijeta_naziv' => 'vegetarijansko']);
        $dijeta->insert(['dijeta_naziv' => 'bez glutena'   ]);

        // create festivity types
        $povod = new \App\Models\Povod();
        $povod->insert(['povod_opis' => 'žurka'   ]);
        $povod->insert(['povod_opis' => 'proslava']);
        $povod->insert(['povod_opis' => 'rođendan']);
        $povod->insert(['povod_opis' => 'slava'   ]);
        $povod->insert(['povod_opis' => 'venčanje']);
        $povod->insert(['povod_opis' => 'krštenje']);
        $povod->insert(['povod_opis' => 'ostalo'  ]);
        $povod->insert(['povod_opis' => 'radije ne bih naveo/la']);

    }
}





