<?php  

	class VoterModel {
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		//Check if user already voted
		public function voteCheck($id) {
			$this->db->query('SELECT * FROM voters WHERE voters_id = :id');
			$this->db->bind(':id', $id);
			$row = $this->db->single();

			if ($this->db->rowCount() == 1) {
				return $row;
			}
			else {
				return false;
			}
		}
		//view vote
		public function viewVote($id) {
			$this->db->query('SELECT *, 
							  candidates.firstname AS canfirst, 
							  candidates.lastname AS canlast 
							  FROM votes 
							  LEFT JOIN candidates 
							  ON candidates.id=votes.candidate_id 
							  LEFT JOIN positions 
							  ON positions.id=votes.position_id 
							  WHERE voters_id = :id  
							  ORDER BY positions.priority ASC');
			$this->db->bind(':id', $id);
			$result = $this->db->resultSet();
			return $result;
		}

		//Select all from positions
		public function getPositions() {
			$this->db->query('SELECT * FROM positions');

			$row = $this->db->resultSet();
			return $row;
		}
		//Execute query
		public function forSub($sql) {
			$this->db->query($sql);
			$this->db->execute();
		}
		//Prepare statement
		public function prep($session,$value,$pos_id){
			$this->db->query('INSERT INTO votes (student_id, voters_id, candidate_id, position_id, program) VALUES (:student_id, :voters_id, :value, :pos_id, :program)');
			$this->db->bind(':student_id', $session['student_id']);
			$this->db->bind(':voters_id', $session['voters_id']);
			$this->db->bind(':value', $value);
			$this->db->bind(':pos_id', $pos_id);
			$this->db->bind(':program', $session['program']);

			$this->db->execute();
		}

		public function updateyes($id,$yes) {
			$this->db->query('UPDATE voters SET voted = :yes WHERE voters_id = :id');
			$this->db->bind(':id', $id);
			$this->db->bind(':yes', $yes);

			$this->db->execute();
		}

		//get all candidates
		public function getCandidates() {
			$this->db->query('SELECT * FROM candidates');
			$row = $this->db->resultSet();
			return $row;
		}

		//Get candidates by id
		public function getCandidatesById($id) {
			$this->db->query('SELECT * FROM candidates WHERE id = :id');
			$this->db->bind(':id', $id);

			$row = $this->db->single();
			return $row;
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
		//Get all positions
		public function getPositionsAsc() {
			$this->db->query('SELECT * FROM positions ORDER BY priority ASC');
			$row = $this->db->resultSet();
			return $row;
		}
		//Get candidates by id
		public function getCandidatesAsc($id) {
			$this->db->query('SELECT * FROM candidates WHERE position_id= :id');
			$this->db->bind(':id', $id);
			$row = $this->db->resultSet();
			return $row;
		}
		//Update voter
		public function updateVoter($data, $id) {
			$this->db->query('UPDATE voters 
							  SET password = :password, firstname = :firstname, 
							  lastname = :lastname, email = :email, photo = :photo 
							  WHERE id = :id');
			$this->db->bind(':id', $id);
			$this->db->bind(':password', $data['password']);
			$this->db->bind(':firstname', $data['firstname']);
			$this->db->bind(':lastname', $data['lastname']);
			$this->db->bind(':email', $data['email']);
			$this->db->bind(':photo', $data['photo']);

			if ($this->db->execute()) {
				return true;
			}
			else {
				return false;
			}
		}
		// Get voter by id
		public function getVoterById($id) {
			$this->db->query('SELECT * FROM voters WHERE id = :id');
			//Bind value
			$this->db->bind(':id', $id);

			$row = $this->db->single();

			return $row;
		}	

	}

?>