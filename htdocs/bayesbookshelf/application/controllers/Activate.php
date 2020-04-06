<?php

class Activate extends CI_Controller{

	public function __construct() { 
			
		parent::__construct();
			
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	} 

	public function index(){
		$this->load->model('User_Model');
		$this->load->helper('url');

		$email = $_GET['user'];
		$token = $_GET['token'];

		if($this->User_Model->updateActive($email, $token)){
			//auto sign in and set cookie
			//$this->load->library('../controllers/Signin');
			//$this->Signin->setLoginCach();
			
			redirect()->route('home');
		}else{
			$param['message'] = "Activation Failed.";
			$this->load->view('error', $param);
		}
		
	}
}

?>