<?php 

class User_Model extends CI_Model{
	public function getAll(){
		$query = $this->db->get("user");
		return $query->result();
	}

	public function get($select, $where){
		if($select != null)
			$this->db->select($select);
		$this->db->from("user");
		if($where != null)
			$this->db->where($where);
		$query = $this->db->get();

		return $query->result();
	}

	public function insert($user){
		return $this->db->insert("user", $user);
	}

	public function delete($email) { 
       	if ($this->db->delete("user", "email = ".$email)) { 
			return TRUE; 
		} 
   	} 
   
	public function update($setArr, $whrArr) { 
		$this->db->set($setArr);
		$this->db->where($whrArr);
		$this->db->update('1user');
	} 

	public function updateActive($email, $token){
		$this->db->set('active', TRUE);
		$this->db->where(array('email'=>$email, 'token'=>$token));
		$this->db->update('1user');
	}

}

?>