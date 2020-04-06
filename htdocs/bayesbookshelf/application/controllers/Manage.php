<?php
class Manage extends CI_Controller{
    
    public function __construct() {        
        parent::__construct();
        
        $this->load->model('Book_Model');
    }
    
    public function index(){
        try{
            $user = $this->session->userdata('member_id');
            if (empty($user)){
                throw new Exception("Please Signin First");
            }
            
            $result = array();
            $len = strpos($this->session->userdata('member_id'),"@");
            $result['user'] = substr($user,0,$len);
            $result['books'] = $this->Book_Model->getAllByUser($user);
            
            $this->load->view('book_manage', $result);
        }catch(Exception $error){
            $result['message'] = $error->getMessage();
            $this->load->view('error', $result);
        }
    }
    
}
?>