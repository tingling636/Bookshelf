<?php
	class Book extends CI_Controller{
		public function __construct(){
			parent::__construct();

			//$this->load->database();
			$this->load->library('form_validation');
			$this->load->library('upload');
			$this->load->helper('url', 'form');

			$this->load->model('Book_Model');
		}

		public function new(){			
			$path = $this->getPath("ResourcePath");
			
			//Read menu list from JSON
			$url = $path."bookshelf_metadata.json";
			$metdata = file_get_contents($url);
			$dataarr = json_decode($metdata, true);
			$data = array();
			$data['cat'] = $dataarr["categoty"];
			$data['lag'] = $dataarr["language"];

			$this->load->view('book_add', $data);
	
		}

		public function save(){
			
			/* 
			$config['upload_path'] = './resources/upload/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = 2000;
			$config['max_width'] = 1500;
			$config['max_height'] = 1500;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);

        	if (!$this->upload->do_upload('imageFile')) {
            	$error = array('error' => $this->upload->display_errors());
				echo json_encode($error);
				$this->load->view('book_add', $error);
			} else 
			{
				$data = array('image_metadata' => $this->upload->data());

				$this->load->view('book_item', $data);
			} */

			$coverImage = null;
			$file = $_FILES['imageFile']['tmp_name'];
			if(!isset($file)){
				$error = array('error' => 'Please select an Image');
			}else {
				$image_check = getimagesize($file);
				if($image_check==false){
					$error = array('error' => 'Not a Valid Image');
				}else{
					$coverImage = addslashes(file_get_contents($file)); //SQL Injection defence!
					$image_name = addslashes($file);
					echo "teset";
				}
			}
		
			$book = array( 
				'bookTitle' => $this->input->post('btitle'),
				'author' => $this->input->post('bauthor'),
				'language' => $this->input->post('blanguage'),
				'category' => $this->input->post('bcategory'),
				'subcategory' => $this->input->post('bsubcategory'),
				'copyright' => $this->input->post('bcopyright'),
				'publisher' => $this->input->post('bpublisher'),
				'isbn' => $this->input->post('bisbn'),
				'paperback' => 100,
				'photo' => $coverImage,
				'review' => $this->input->post('breview'),
				'rank' =>  0,
				'createDate' => date("Y-m-d h:i:sa"),
				'postBy' => "user"
			); 

			$id = $this->Book_Model->insert($book); 
			$this->viewBook($id);
		}
		
		public function viewBook($id){
			$result['data'] = $this->Book_Model->get(null, array('id' => $id));
			$result['items'] = $this->Book_Model->getItems(null, array('book_id' => $id));

			$this->load->view('book_item', $result);
		}

		public function getPath($type){
			// document root
			$doc_root = $_SERVER['DOCUMENT_ROOT'];

			// base directory
			$base_dir =str_replace("\\","/",__DIR__);

			// server protocol
			$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

			// domain name
			$domain = $_SERVER['SERVER_NAME'];

			// base url
			$base_url = preg_replace("!^${doc_root}!", '', $base_dir);

			// server port
			$port = $_SERVER['SERVER_PORT'];
			$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

			// put em all together to get the complete base URL
			$url = "${protocol}://${domain}${disp_port}${base_url}";
			$imagepath = "${protocol}://${domain}${disp_port}/img/";
			$resourcepath = "${protocol}://${domain}${disp_port}/resources/";

			if($type == "ImagePath"){
				return ($imagepath);
			}elseif ($type == "ResourcePath"){
				return ($resourcepath);
			}else {
				return ($url);
			}			
		}

	}
?>