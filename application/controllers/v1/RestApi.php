<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class RestApi extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
		$this->load->model('KeyModel');
		//$mysql = $this->load->database('default', TRUE);
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['api_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['api_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['api_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->methods['api_put']['limit'] = 50; // 50 requests per hour per user/key
    }

    public function carabayar_get()
    {
		$id = $this->get('id');
		$response =$this->KeyModel->check_auth_client();	
		if($response['status'] == 200){
			$resp = $this->KeyModel->getcarabayar($id);
			//var_dump($resp);
			if($resp == NULL){
			$message = [
			'status' => '400',
            'message' => 'Data not found.'
			];
			$this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
			}else{
			$this->set_response($resp, REST_Controller::HTTP_OK);	
			}
		}else{
			//echo json_encode($response);
			//log_message('error', "ok");
			$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); 
		}
		
    }
	
	public function klinik_get()
    {
		$id = $this->get('id');
		$response =$this->KeyModel->check_auth_client();	
		if($response['status'] == 200){
			$resp = $this->KeyModel->getklinik($id);
			//var_dump($resp);
			if($resp == NULL){
			$message = [
			'status' => '400',
            'message' => 'Data not found.'
			];
			$this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
			}else{
			$this->set_response($resp, REST_Controller::HTTP_OK);	
			}
		}else{
			//echo json_encode($response);
			//log_message('error', "ok");
			$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); 
		}
		
    }
	
	public function ruang_get()
    {
		$id = $this->get('id');
		$response =$this->KeyModel->check_auth_client();	
		if($response['status'] == 200){
			$resp = $this->KeyModel->getruang($id);
			//var_dump($resp);
			if($resp == NULL){
			$message = [
			'status' => '400',
            'message' => 'Data not found.'
			];
			$this->set_response($message, REST_Controller::HTTP_NO_CONTENT);
			}else{
			$this->set_response($resp, REST_Controller::HTTP_OK);	
			}
		}else{
			//echo json_encode($response);
			//log_message('error', "ok");
			$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST); 
		}
		
    }

    public function api_post()
    {
        // $this->some_model->update_user( ... );
        $message = [
            'id' => 100, // Automatically generated by the model
            'name' => $this->post('name'),
            'email' => $this->post('email'),
            'message' => 'Added a resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

    public function api_delete()
    {
        $id = (int) $this->get('id');

        // Validate the id.
        if ($id <= 0)
        {
            // Set the response and exit
            $this->response(NULL, REST_Controller::HTTP_BAD_REQUEST); // BAD_REQUEST (400) being the HTTP response code
        }

        // $this->some_model->delete_something($id);
        $message = [
            'id' => $id,
            'message' => 'Deleted the resource'
        ];

        $this->set_response($message, REST_Controller::HTTP_NO_CONTENT); // NO_CONTENT (204) being the HTTP response code
    }

}
