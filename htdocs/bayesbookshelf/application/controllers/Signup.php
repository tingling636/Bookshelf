<?php

class Signup extends CI_Controller {

	public function __construct(){
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('email');
		$this->load->model('User_Model');
	}

	public function index(){
		$this->form_validation->set_rules('username', 'Email', 'trim|required|valid_email|callback_email_check');
		$this->form_validation->set_rules('pass', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[pass]', array('matches[pass]' => 'Password Not Match!!'));
		
		if ($this->form_validation->run() == FALSE){
			$param['message'] = '';
			$this->load->view('error',$param);
		}else{
			//Find user current location
			$vis_ip = $this->getVisIPAddr();
			$ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $vis_ip)); 
			$country = $ipdat->geoplugin_countryName;
			$country = "Malaysia";

			$useremail = $this->input->post('username');
			$username = explode('@',$useremail)[0];
			//Hashed the password
			$hash_pass = password_hash($this->input->post('pass'), PASSWORD_DEFAULT);
			//Generate activation token
			$token = $this->generateRandomToken(15);

			//Save data into user table
			$user = array(
				'email' 		=> $useremail,
				'password' 		=> $hash_pass,
				'country' 		=> $country,
				'active' 		=> FALSE,
				'token' 		=> $token,
				'createDate'	=> date("Y-m-d h:i:sa")
			);

			if($this->User_Model->insert($user)){
				$this->load->view('book_manage');
			}else{
				$param['message'] = "Sig Up process failed. Try again.";
				$this->load->view('error',$param);
			}

			//Generate activation link 
			$link = $this->createLink(base_url('index.php/activate'), $useremail, $token);
			
			//send email to user
			//$config['wordwrap'] = FALSE;
			//$this->email->initialize($config);

			$emailmsg = "Hi {$username},<br><br>Thank you for interested on our services.<br><br> Please click <a href='{$link}'>{unwrap}{$link}{/unwrap}</a> for your account activation.";
			$this->email->from('no-reply@bayesthinks.com','Bayes Bookshelf');
			$this->email->to($useremail);
			$this->email->subject("MyBookShelf Account Activation");
			$this->email->message($emailmsg);

			$this->email->send();

			redirect()->route('home');
		}
	}

	public function email_check($str){
		$this->db->where('email', $str);
		$q = $this->db->get('1user');
		$row = $q->row();

		if(isset($row)){
			$this->form_validation->set_message('email_check', 'This emai id already be registed.');
			return FALSE;
		}else{
			return TRUE;
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

	/**
	 *  Creates a link by appending the user and token to the URL parameters preserving other parts of the URL.
	 */
	function createLink($baseurl, $userId, $randomToken){
		$urlParts = parse_url($baseurl);

		if($urlParts != null){
			$newQueryParams = http_build_query(array('user'=>$userId, 'token'=>$randomToken));

			// Detect a fragment and if it exists, preserve it.
			$frag = '';
			if(array_key_exists('fragment', $urlParts)){
				$frag = '#'.$urlParts['fragment'];
				$baseurl = str_replace($frag, '', $baseurl);
			}

			// If there is a query string, append our new parameters to it.
			if(array_key_exists('query', $urlParts) && !empty($urlParts['query'])){
				$baseUrl = str_replace($urlParts['query'], $urlParts['query'] . "&$newQueryParams", $baseUrl);
			}else{
				$baseurl .= "?{$newQueryParams}";
			}

			return $baseurl.$frag;
		}

		return "";
	}
	
	function getVisIpAddr() { 
      
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
     	   return $_SERVER['HTTP_CLIENT_IP']; 
   		}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        	return $_SERVER['HTTP_X_FORWARDED_FOR']; 
   	 	}else { 
        	return $_SERVER['REMOTE_ADDR']; 
    	} 
	} 
}

?>