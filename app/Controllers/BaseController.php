<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\CommonModel;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['common_helper'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->common_model = new CommonModel;
        $this->session = \Config\Services::session();
        $this->uri = new \CodeIgniter\HTTP\URI();
    }
    public function layout_before_login($title,$page_name,$data)
    {
        $this->session              = \Config\Services::session();
        $data['session']            = $this->session;
        $data['Common_model']       = new CommonModel;        

        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['title']              = $title.'-'.$data['general_settings']->site_name;
        $data['page_header']        = $title;

        $data['head']               = view('admin/elements/before-head',$data);
        $data['maincontent']        = view('admin/maincontents/'.$page_name,$data);
        return view('admin/layout-before-login',$data);
    }
    public function layout_after_login($title,$page_name,$data)
    {
        $this->session              = \Config\Services::session();
        $data['session']            = $this->session;
        $data['common_model']       = new CommonModel;
        $user_id                    = $this->session->get('user_id');
        
        $data['general_settings']   = $this->common_model->find_data('general_settings','row');
        $data['admin']              = $this->common_model->find_data('ecoex_admin_user','row', ['id' => $user_id]);
        $data['title']              = $title.'-'.$data['general_settings']->site_name;
        $data['page_header']        = $title;

        $data['head']           = view('admin/elements/after-head',$data);
        $data['header']         = view('admin/elements/header',$data);
        $data['sidebar']        = view('admin/elements/sidebar',$data);
        $data['footer']         = view('admin/elements/footer',$data);
        $data['maincontent']    = view('admin/maincontents/'.$page_name,$data);
        return view('admin/layout-after-login',$data);
    }
    public function isJSON($string)
    {        
        $valid = is_string($string) && is_array(json_decode($string, true)) ? true : false;

        if (!$valid) {
            $this->response_to_json(FALSE, "Not JSON", 401);
        }
    }
    /* Process json from request */
    public function extract_json($key)
    {
        return json_decode($key, TRUE);
    }
    /* Methods to check all necessary fields inside a requested post body */
    public function validateArray($keys, $arr)
    {
        return !array_diff_key(array_flip($keys), $arr);
    }
    /*
     Set response message
     response_to_json = set_response
    */    
    public function response_to_json($success = TRUE, $message = "success", $data = NULL, $extraField = NULL, $extraData = NULL)
    {
        $response = ["success" => $success, "message" => $message, "data" => $data];
        if ($extraField != NULL && $extraData != NULL) {
            $response[$extraField] = $extraData;
        }
        print json_encode($response);
        die;
    }
    public function responseJSON($data)
    {
        print json_encode($data);
        die;
    }

    public function sendMail($to_email, $email_subject, $mailbody, $attachment = '')
    {
        $siteSetting        = $this->common_model->find_data('general_settings', 'row');
        $email              = \Config\Services::email();        
        $from_email         = 'no-reply@market.ecoex.market';
        $from_name          = $siteSetting->site_name;
        $email->setFrom($from_email, $from_name);
        $email->setTo($to_email);
        $email->setCC('subhomoy@keylines.net', 'Ecoex Commodity Trading');
        // $email->setCC('info@ecoex.market', 'Ecoex Portal');
        $email->setSubject($email_subject);
        $email->setMessage($mailbody);
        if($attachment != ''){
            $email->attach($attachment);
        }
        $email->send();
        return true;
    }
}
