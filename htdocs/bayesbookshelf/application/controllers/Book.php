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
			$url = base_url('/resources/bookshelf_metadata.json');
			$metdata = file_get_contents($url);
			$dataarr = json_decode($metdata, true);
			$data = array();
			$data['cat'] = $dataarr["categoty"];
			$data['lag'] = $dataarr["language"];

			$this->load->view('book_add', $data);
	
		}
		
		public function manage(){
		    try{
		        $user = $this->session->userdata('member_id');
		        if(empty($user)){
		            throw new Exception('Please Signin First.');
		        }
		        
		        $this->db->where('postBy', $user);
		        $q = $this->db->get('1book');
		        $result['books'] = $q->result();
		            
		        $this->load->view('book_manage', $result);
		    }catch (Exception $error){
		        $param['message'] = $error;
		        $this->load->view('error', $param);
		    }
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

		    try{
		        $user = $this->session->userdata('member_id');
		        if(empty($user)){
		            throw new Exception('Please Signin First.');
		        }
		        
		        $coverImage = null;
		        $file = $_FILES['imageFile']['tmp_name'];
		        $temp = $_FILES['imageFile']['name'];
		        if(empty($file) || strlen($file) <=0){
		            throw new Exception('Please select an Image');		            
		        }else {
		            $image_check = getimagesize($file);
		            if($image_check==false){
		                throw new Exception('Not a Valid Image');
		            }else{
		                //$coverImage = addslashes(file_get_contents($file)); //SQL Injection defence!
		                //$image_name = addslashes($file);

		                $coverImage = base64_encode(file_get_contents(addslashes($file)));
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
		            'paperback' => intval($this->input->post('bpapercover')),
		            'photo' => $coverImage,
		            'review' => $this->input->post('breview'),
		            'rank' =>  0,
		            'createDate' => date("Y-m-d h:i:sa"),
		            'postBy' => $user
		        );
		        
		        
		        $id=  $this->Book_Model->insert($book);
		        if($id == -1)
		            throw new Exception('Insert new Book Failed');
		        
		        $this->viewBook($id);
		        
		    }catch(Exception $error){
		        $param['message'] = $error->getMessage();
		        $this->load->view('error', $param);
		    }
		}
		
		public function fetch(){		    
		    try{
		        $user = $this->session->userdata('member_id');
		        if (empty($user)){
		            throw new Exception("Please Signin First");
		        }
		        
		        /* $result = array();
		        $len = strpos($this->session->userdata('member_id'),"@");
		        $result['user'] = substr($user,0,$len);
		        $result['books'] = $this->Book_Model->getAllByUser($user); */
		        $books =  $this->Book_Model->getAllByUser($user);
		        
		        $data = array();		
		        $no = 0;
		        foreach($books as $obj){
		            $row = $obj['book'];
		            $status = $obj['status'];
		            $no++;
		            
		            $sub_array = array();
		            $sub_array[] = '<div class="p-1">' . $no . '.</div>';
		            $sub_array[] = '<div contenteditable class="update p-1" data-id="'.$row->id.'" data-column="title">' . $row->bookTitle . '</div>';
		            $sub_array[] = '<div contenteditable class="update" data-id="'.$row->id.'" data-column="author">' . $row->author . '</div>';
		            $sub_array[] = '<div contenteditable class="update p-1" data-id="'.$row->id.'" data-column="language">' . $row->language . '</div>';
		            $sub_array[] = '<div contenteditable class="update" data-id="'.$row->id.'" data-column="subcategory">' . $row->subcategory . '</div>';
		            $sub_array[] = '<div contenteditable class="update p-1" data-id="'.$row->id.'" data-column="rank">' . $row->rank . '</div>';
		            $sub_array[] = '<div contenteditable class="update" data-id="'.$row->id.'" data-column="status">' . $status . '</div>';
		            $sub_array[] = '<button type="button" name="act1" class="btn btn-danger btn-xs act1" style="font-size: x-small" id="'.$row->id.'">Delete</button> <button type="button" name="act2" class="btn btn-primary btn-xs act2" style="font-size: x-small" id="'.$row->id.'">Edit</button>';
		            $data[] = $sub_array;
		        }
		        
		       
		        $output = array(
		            "draw"    => 1,
		            "recordsTotal"  =>  count($books),
		            "recordsFiltered" => count($books),
		            "data"    => $data
		        );
		        
		        echo json_encode($output); 
		        
		        //$this->load->view('book_manage', $result);
		    }catch(Exception $error){
		        $result['message'] = $error->getMessage();
		        $this->load->view('error', $result);
		    }
		}
		
		public function delete(){
		    if(isset($_POST["id"])){
		        if($this->Book_Model->delete($_POST["id"]))		        
		          echo 'Data Deleted '.$_POST["id"];
		        else 
		          echo "Delete Failed";
		    }
		}
		
		public function viewBook($id){
		    try{
    			$result['data'] = $this->Book_Model->get(null, array('id' => $id));
    			$result['items'] = $this->Book_Model->getItems(null, array('book_id' => $id));
    
    			$this->load->view('book_item', $result);
		    }catch(ErrorException $error){
		        $param['message'] = $error->getMessage();
		        $this->load->view('error', $param);
		    }
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