<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
// 2020-05-18 v0.1 Marko Stanojevic 2017/0081

/**
 * filter for all client requests, checks if the client is calling their respective controller
 * 
 * @version 0.1
 */
class Filter implements FilterInterface
{
    /**
     * pre-filter that gets called on the request before the controller receives it
     */
    public function before(RequestInterface $request)
    {
        // initialize or continue the user session
        $session = session();
        // get the user type from the session
        $kor_tipkor = $session->get('kor_tipkor');
        
        // if the user type doens't exist
        if( !isset($kor_tipkor) )
        {
            // set it as the default user type -- guest (not logged in)
            $kor_tipkor = 'Gost';
            // save the user type in the session
            $session->set( compact('kor_tipkor') );
        }
        
        // get the controller from the uri path segment
        $controller = $request->uri->getSegment(1);
        // if the user asked for a different controller than their type, redirect them to their default controller
        if( $controller !== $kor_tipkor )
        {
            // change the default controller to the user type
            $controller = $kor_tipkor;
            // redirect the user to their default method
            return redirect()->to( base_url(nightbird_def_path[$controller]) );
        }
    }

    /**
     * post-filter that gets called on the request and response after the controller creates a response
     */
    public function after(RequestInterface $request, ResponseInterface $response)
    {}
}