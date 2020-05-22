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
        $tipkor = new \App\Models\Tipkor();
        $tipkor->insert(['tipkor_naziv' => 'Admin'   ]);
        $tipkor->insert(['tipkor_naziv' => 'Menadzer']);
        $tipkor->insert(['tipkor_naziv' => 'Kuvar'   ]);
        $tipkor->insert(['tipkor_naziv' => 'Korisnik']);

        // create generic users of all types
        $kor = new \App\Models\Kor();
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
        $tipjela = new \App\Models\Tipjela();
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
        $ukus = new \App\Models\Ukus();
        $ukus->insert(['ukus_naziv' => 'Slatko' ]);
        $ukus->insert(['ukus_naziv' => 'Slano'  ]);
        $ukus->insert(['ukus_naziv' => 'Ljuto'  ]);
        $ukus->insert(['ukus_naziv' => 'Gorko'  ]);
        $ukus->insert(['ukus_naziv' => 'Kiselo' ]);

        // create diet types
        $dijeta = new \App\Models\Dijeta();
        $dijeta->insert(['dijeta_naziv' => 'Nije dijetalno' ]);
        $dijeta->insert(['dijeta_naziv' => 'Mrsno'          ]);
        $dijeta->insert(['dijeta_naziv' => 'Posno'          ]);
        $dijeta->insert(['dijeta_naziv' => 'Vegetarijansko' ]);
        $dijeta->insert(['dijeta_naziv' => 'Vegansko'       ]);
        $dijeta->insert(['dijeta_naziv' => 'Bez glutena'    ]);
        $dijeta->insert(['dijeta_naziv' => 'Bez laktoze'    ]);

        // create festivity types
        $povod = new \App\Models\Povod();
        $povod->insert(['povod_opis' => 'Žurka'   ]);
        $povod->insert(['povod_opis' => 'Proslava']);
        $povod->insert(['povod_opis' => 'Rođendan']);
        $povod->insert(['povod_opis' => 'Slava'   ]);
        $povod->insert(['povod_opis' => 'Venčanje']);
        $povod->insert(['povod_opis' => 'Krštenje']);
        $povod->insert(['povod_opis' => 'Ostalo'  ]);
        $povod->insert(['povod_opis' => 'Radije ne bih naveo/la']);

    }
}





