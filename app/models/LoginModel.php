<?php  

	class LoginModel {
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		//Login User
		public function vlogin($id) {
			$this->db->query('SELECT * FROM voters WHERE voters_id = :id');
			$this->db->bind(':id', $id);

			$row = $this->db->single();

			// Check row
			if ($this->db->rowCount() > 0) {
				return $row;
			}
			else {
				return false;
			}
		}

		//Login Admin
		public function alogin($id) {
			$this->db->query('SELECT * FROM admin WHERE username = :id');
			$this->db->bind(':id', $id);

			$row = $this->db->single();

			// Check row
			if ($this->db->rowCount() > 0) {
				return $row;
			}
			else {
				return false;
			}
		}

		// check if voter doesn't exist
		public function voterDontExist($id) {
			$this->db->query('SELECT * FROM voters WHERE voters_id = :id');
			//Bind value
			$this->db->bind(':id', $id);

			$row = $this->db->single();

			// Check row
			if ($this->db->rowCount() < 1) {
				return true;
			}
			else {
				return false;
			}
		}

		// check if admin doesn't exist
		public function adminDontExist($id) {
			$this->db->query('SELECT * FROM admin WHERE username = :id');
			//Bind value
			$this->db->bind(':id', $id);

			$row = $this->db->single();

			// Check row
			if ($this->db->rowCount() < 1) {
				return true;
			}
			else {
				return false;
			}
		}


		// Get user by id
		public function getUserById($id) {
			$this->db->query('SELECT * FROM users WHERE id = :id');
			//Bind value
			$this->db->bind(':id', $id);

			$row = $this->db->single();

			return $row;
		}

		

	}

?>