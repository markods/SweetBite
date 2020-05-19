<?php
// 2020-05-19 v0.2 Marko Stanojevic 2017/0081

// map from user types to their default methods
defined('nightbird_def_method') ||
define ('nightbird_def_method', [
    'Gost'     => 'jela',
    'Korisnik' => 'jela',
    'Kuvar'    => 'porudzbine',
    'Menadzer' => 'porudzbine',
    'Admin'    => 'nalozi',
]);

// map from user types to their default routes
defined('nightbird_def_path') ||
define ('nightbird_def_path', [
    'Gost'     => 'Gost/jela',
    'Korisnik' => 'Korisnik/jela',
    'Kuvar'    => 'Kuvar/porudzbine',
    'Menadzer' => 'Menadzer/porudzbine',
    'Admin'    => 'Admin/nalozi',
]);

// map from default methods to their (tab) display names
// this bit of code should be in the language folder, but I haven't researched how to use it
defined('nightbird_tab_name') ||
define ('nightbird_tab_name', [
    'jela'       => 'Jela',
    'porudzbine' => 'Porudžbine',
    'nalozi'     => 'Nalozi',
]);
