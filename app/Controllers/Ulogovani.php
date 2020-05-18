<?php namespace App\Controllers;
// 2020-05-15 v0.1 Marko Stanojevic 2017/0081


/**
 * this is the base class for controllers that handle requests from logged-in users
 */
class Ulogovani extends BaseController
{
    /**
     * log the client out of the system
     */
    public function logout()
    {
        // completely kill the session (remove the old session_id, destroy all server data and the client side cookie that contained the session id)
        $this->session->stop();
        // redirect the user to the default controller
        $this->sendAJAX(['redirect' => base_url("Gost/index")]);
    }
    
}
