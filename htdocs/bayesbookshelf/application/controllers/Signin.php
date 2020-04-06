<?php

class Signin extends CI_Controller{
	
	public function __construct() { 
			
		parent::__construct();
			
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('cookie');
		$this->load->library('session');
	} 

	public function index(){
		$isAuthenticated = false;

		$username = $_POST["member_name"];
		$password = $_POST["member_password"];
				
		$this->db->where('email', $username);
		$q = $this->db->get('1user');
		$user = $q->result();
		if($user == null){
			$param['message'] = "Invalid Username";
			$this->load->view('error', $param);
			return;
		}else{
			if($user[0]->active == FALSE){
				$param['message'] = "The account no activate yet.";
				$this->load->view('error', $param);
				return;
			}

			$isAuthenticated = password_verify(trim($password), trim($user[0]->password));
		}

		//Set Cookie & Session
		if($isAuthenticated){
			$this->setLoginCach($user, $_POST["remember"]);
			redirect()->route('home');
		}else{
			$param['message'] = "Login Fail.";
			$this->load->view('error', $param);
			return;
			
		}
	}

	public function setLoginCach($user, $rememberme){		
		//set login user into session
		//$_SESSION["member_id"] = $user[0]->email;
		$this->session->set_userdata('member_id', $user[0]->email);
		
		//set login user into cookie with 30 days expire 
		$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  
		if ($rememberme) {
			set_cookie("member_login", $user[0]->email, $cookie_expiration_time);
			
			/*
			$random_password = $this->generateRandomToken(16);
			set_cookie("random_password", $random_password, $cookie_expiration_time);
				
			$random_selector = $this->generateRandomToken(32);
			set_cookie("random_selector", $random_selector, $cookie_expiration_time);
				
			$random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
			$random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
				
			$expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);

			// mark existing token as expired
			$userToken = $auth->getTokenByUsername($username, 0);
			if (! empty($userToken[0]["id"])) {
				$auth->markAsExpired($userToken[0]["id"]);
			}
			
			// Insert new token
			$auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
			*/
		}else{
			$this->clearAuthCookie();
		}
	}

	/**
	 * Generates a randowm token string 
	 */
	function generateRandomToken($length = 20){
		$chars = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charsLength = strlen($chars);
		$randomString = '';

		for($i=0; $i<$length; $i++){
			$randomString .= $chars[rand(0, $charsLength-1)];
		}

		return $randomString;
	}

	public function clearAuthCookie() {
		
		//$this->session->unset_userdata('member_id');
		//$this->session->sess_destroy();
		
		delete_cookie('member_login');
		/* $_SESSION["member_id"] = "";

		if (isset($_COOKIE["member_login"])) {
			setcookie("member_login", "");
		}
		if (isset($_COOKIE["random_password"])) {
			setcookie("random_password", "");
		}
		if (isset($_COOKIE["random_selector"])) {
			setcookie("random_selector", "");
		} */
		
	}
}

?>