<?php namespace App\Controllers;
use App\Models\KorisnikModel;
// Jovana Jankovic 0586/17, Filip Lucic 0188/17


class Korisnik extends Ulogovani
{
    // draw the client index page
    public function index()
    {
        // set the client html to the template page, with the given parameters
        return view('templejt/templejt-html.php');
    }
    
}



