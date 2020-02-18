<?php
	class Home extends CI_Controller{
		public function __construct() 
        { 
            parent::__construct();
			$this->load->helper('url'); 
		} 
		
		public function index(){
			$json = file_get_contents(__DIR__ ."\books.json");
			$books  = json_decode($json);
			$result['data']= $books;
			
			$bookarr = array();
			$this->db->distinct();
			$this->db->select('subcategory');
			$this->db->from('1book');
			$query = $this->db->get();
			$rs = $query->result(); 
			foreach($rs as $obj){
				$this->db->where('subcategory', $obj->subcategory);
				$q = $this->db->get('1book');
				array_push($bookarr, array("cat"=>$obj->subcategory, "items"=>$q->result()));
			}
			$result['books'] = $bookarr;

			$this->load->view('home', $result);			
			
		}

		public function login(){
			session_start();
			// Get Current date, time
			$current_time = time();
			$current_date = date("Y-m-d H:i:s", $current_time);

			// Set Cookie expiration for 1 month
			$cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);  

			if (! empty($_POST["login"])) {
				
				$isAuthenticated = false;
		
				$username = $_POST["member_name"];
				$password = $_POST["member_password"];
				
				$this->db->where('email', $username);
				$q = $this->db->get('1user');
				$user = $q->result();
				if($user == null){
					$message = "Invalid Username";
					return;
				}

				/* if (password_verify($password,$user[0]->password)) {
					$isAuthenticated = true;
				} */
				if($password == $user[0]->password){
					$isAuthenticated = true;
				}
				
				if ($isAuthenticated) {
					$_SESSION["member_id"] = $user[0]->email;
			
					// Set Auth Cookies if 'Remember Me' checked
					if (! empty($_POST["remember"])) {
						setcookie("member_login", $username, $cookie_expiration_time);
				
						$random_password = $this->getToken(16);
						setcookie("random_password", $random_password, $cookie_expiration_time);
				
						$random_selector = $this->getToken(32);
						setcookie("random_selector", $random_selector, $cookie_expiration_time);
				
						$random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
						$random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
				
						$expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
						
					/* 
						// mark existing token as expired
						$userToken = $auth->getTokenByUsername($username, 0);
						if (! empty($userToken[0]["id"])) {
							$auth->markAsExpired($userToken[0]["id"]);
						}
						// Insert new token
						$auth->insertToken($username, $random_password_hash, $random_selector_hash, $expiry_date);
					*/
					} else {
						$this->clearAuthCookie();
					}
					$this->index();
					
				} else {
					$message = "Invalid Login";
				}
			} 
		}

		public function getToken($length)
		{
			$token = "";
			$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
			$codeAlphabet .= "0123456789";
			$max = strlen($codeAlphabet) - 1;
			for ($i = 0; $i < $length; $i ++) {
				$token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
			}
			return $token;
		}

		public function cryptoRandSecure($min, $max)
		{
			$range = $max - $min;
			if ($range < 1) {
				return $min; // not so random...
			}
			$log = ceil(log($range, 2));
			$bytes = (int) ($log / 8) + 1; // length in bytes
			$bits = (int) $log + 1; // length in bits
			$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
			do {
				$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
				$rnd = $rnd & $filter; // discard irrelevant bits
			} while ($rnd >= $range);
			return $min + $rnd;
		}

		public function clearAuthCookie() {
			//$_SESSION["member_id"] = "";
			//session_destroy();

			if (isset($_COOKIE["member_login"])) {
				setcookie("member_login", "");
			}
			if (isset($_COOKIE["random_password"])) {
				setcookie("random_password", "");
			}
			if (isset($_COOKIE["random_selector"])) {
				setcookie("random_selector", "");
			}

			$this->index();
		}
	
	public function displayImage(){
		$bookarr = array();
		$this->db->distinct();
		$this->db->select('subcategory');
		$this->db->from('1book');
		$query = $this->db->get();
		$rs = $query->result(); 
		foreach($rs as $obj){
			$this->db->where('subcategory', $obj->subcategory);
			$q = $this->db->get('1book');
			$images = array();
			foreach($q->result() as $row) {
				$images[] = $row->photo;
			}
			foreach ($images as $image) {
			//echo '<img src="data:image/jpeg;base64,'. base64_encode($image) .'" />';
			echo "<img src='data:image/jpeg;base64,".base64_encode($image)."'/>";
			}
		}
	}
	}
?>