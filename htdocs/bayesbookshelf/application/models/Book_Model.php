<?php
	class Book_Model extends CI_Model{

	    public function getAllByUser($user){
	        $this->db->from("1book");
	        $this->db->where("postBy='". $user ."'");	        
			$query = $this->db->get();
			
			$books = array();
			$rs = $query->result();
			foreach($rs as $book){
			    $exStatus = "None";
			    
			    $item = $this->getItems(null,"book_id=".$book->id);
			    if( !empty($item)){
			        if($item->openExchange)
			            $exStatus = "Valid";
			        else if($item->issueTo != null)
			            $exStatus = "Issued";
			    }
			    
			    $data = array("book" => $book, "item" => $item, "status" => $exStatus);
			    array_push($books, $data);
			}
			return $books;
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
		  /*   $conn = mysqli_connect('localhost', 'root', '','bookshelf');
		    $sqlInsertimageintodb = "INSERT INTO `1book`(`bookTitle`, `author`, `language`, `category`, `subcategory`, `copyright`, `publisher`, `isbn`, ".
                "`paperback`, `photo`, `review`, `createDate`, `postBy`) VALUES (".$book['bookTitle'].",".$book['author'].",".$book['language'].",".$book['category'].",".
                $book['subcategory'].",".$book['copyright'].",".$book['publisher'].",".$book['isbn'].",".$book['paperback'].",".$book['photo'].",".$book['review'].",".$book['createDate'].",".$book['postBy'].")";
		    mysqli_query($conn, $sqlInsertimageintodb); */
		    
		    if ($this->db->insert("book", $book)){
		        $id = $this->db->insert_id();
				return $id;
		    }else 
				return -1;
		}

		public function delete($id) { 
        	if ($this->db->delete("book", "id = ".$id)) { 
				return true; 
        	} else {
        	    return false;
        	}
      	} 
   
		public function update($book,$old_roll_no) { 
			$this->db->set($book); 
			$this->db->where("roll_no", $old_roll_no); 
			$this->db->update("book", $book); 
		} 
	}
?>