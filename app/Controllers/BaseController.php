<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['url'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
            // Do Not Edit This Line
            parent::initController($request, $response, $logger);

            //--------------------------------------------------------------------
            // Preload any models, libraries, etc, here.
            //--------------------------------------------------------------------
            // E.g.:
            
            // pokretanje sesije
            $this->session = \Config\Services::session();
	}

        /**
         * decode the JSON received data from the AJAX request
         * return it as an associative array
         * 
         * @return associative array
         */
        protected function receiveAJAX()
        {
            return $this->request->getJSON(true);
        }
        
        /*
         * encode the given data as a JSON object
         * send an AJAX response to the client
         * 
         * @param data -- the data that will be sent as the response
         */
        protected function sendAJAX($data)
        {
            $this->response->setJSON($data)->send();
        }
}
