<?php

class Home extends CI_Controller{
	
	public function __construct() { 
			
		parent::__construct();
			
		$this->load->library('form_validation');
	} 
		
	public function index(){
		//Get the best books for carousel display
		$url = __DIR__ ."\\top_books.xml";
		$xml=simplexml_load_file($url) or die("Error: Cannot create object");
		$books = [];
		foreach($xml->children() as $node1) {	//convert xml element to array
			$book = [];
			foreach($node1->children() as $node) {
				$book[$node->getName()] = is_array($node) ? simplexml_to_array($node) : (string) $node;
			}
			array_push($books,$book);
		}

		$result['data']= $books;
			
		//Retrieve all books from database by categories
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

	public function logout(){
	    $this->session->unset_userdata('member_id');
	    $this->session->sess_destroy();
	    
	    delete_cookie('member_login');
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