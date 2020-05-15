<?php namespace App\Controllers;
// 2020-05-14 v0.1 Marko Stanojevic 2017/0081


// this is the default controller for the web application
// it handles requests from two types of users -- those that aren't logged in and the customer (when they log in)
class Gost extends BaseController
{
    // draw the client index page
    public function index()
    {
        // set the client html to the template page, with the given parameters
        return view('templejt/templejt-html.php');
    }
    
    /**
     * log the client into the system
     */
    public function login()
    {
        
    }
    
    /**
     * log the client out of the system
     */
    public function register()
    {
        $arr = $this->receiveAJAX();
        
        $arr['hey'] = 'yeh';
        $arr['heyy'] = 'yyeh';

        $this->sendAJAX($arr);
    }

}
