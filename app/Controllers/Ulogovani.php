<?php namespace App\Controllers;
// 2020-05-15 v0.1 Marko Stanojevic 2017/0081


/**
 * this is the base class for controllers that handle requests from logged-in users
 * 
 * @version 0.1
 */
class Ulogovani extends BaseController
{
    /**
     * log the client out of the system
     */
    public function logout()
    {
        // destroy the session
        $this->session->destroy();
        // redirect the user to the default controller
        $this->sendAJAX(['redirect' => base_url("Gost/jela")]);
    }
    
}
