<?php namespace App\Controllers;
// 2020-05-14 v0.1 Marko Stanojevic 2017/0081

class Gost extends BaseController
{
    // draw the guest index page
    public function index()
    {
        // return view('welcome_message.php');
        return view('templejt/templejt-html.php');
    }
    
    public function login()
    {
    }
    
    public function register()
    {
        $arr = $this->receiveAJAX();
        
        $arr['hey'] = 'yeh';
        $arr['heyy'] = 'yyeh';

        $this->sendAJAX($arr);
    }

}
