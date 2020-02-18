<?php
	class Book_Model extends CI_Model{

		public function getAll(){
			$query = $this->db->get("book");
			return $query->result();
		}

		public function get($select, $where){
			if($select != null)
				$this->db->select($select);
			$this->db->from("book");
			if($where != null)
				$this->db->where($where);
			$query = $this->db->get();

			return $query->result();
		}

		public function getItems($select, $where){
			if($select != null)
				$this->db->select($select);
			$this->db->from("book_item");
			if($where != null)
				$this->db->where($where);
			$query = $this->db->get();

			return $query->result();
		}

		public function insert($book){
			if ($this->db->insert("book", $book))
				return $this->db->insert_id();
			else
				return false;
		}

		public function delete($id) { 
        	if ($this->db->delete("book", "id = ".$id)) { 
				return true; 
			} 
      	} 
   
		public function update($book,$old_roll_no) { 
			$this->db->set($book); 
			$this->db->where("roll_no", $old_roll_no); 
			$this->db->update("book", $book); 
		} 
	}
?>