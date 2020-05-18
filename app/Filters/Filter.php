<?php namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class Filter implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // initialize or continue the session
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
            return redirect()->to( base_url("{$kor_tipkor}/index") );
    }

    public function after(RequestInterface $request, ResponseInterface $response)
    {}
}